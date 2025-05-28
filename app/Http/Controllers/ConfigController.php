<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ConfigController extends Controller
{
    public function index()
    {
        $configs = Config::orderBy('key')->get();

        return view('super-admin.pages.setting.config.index', [
            'configs' => $configs,
            'pageTitle' => 'Content Management System'
        ]);
    }

    public function show(Request $request)
    {
        $section = $request->input('section');
        $configs = Config::where('key', 'like', $section . '_%')->get();

        return view('super-admin.pages.setting.config.show', compact('configs', 'section'));
    }

    public function edit(Request $request)
    {
        $section = $request->input('section');
        $configs = Config::where('key', 'like', $section . '_%')->get();

        return view('super-admin.pages.setting.config.edit', compact('configs', 'section'));
    }

    public function update(Request $request)
    {
        try {
            foreach ($request->all() as $key => $value) {
                if (in_array($key, ['_token', '_method']) || str_ends_with($key, '_id')) {
                    continue;
                }

                $configId = $request->input($key . '_id');
                if (!$configId) {
                    continue;
                }

                $config = Config::find($configId);
                if (!$config) {
                    continue;
                }

                if ($config->type === 'image') {
                    if ($request->hasFile($key)) {
                        // Hapus file lama jika ada
                        if ($config->value && Storage::disk('public')->exists($config->value)) {
                            Storage::disk('public')->delete($config->value);
                        }

                        // Simpan file baru
                        $path = $request->file($key)->store('configs', 'public');
                        $config->value = $path;
                    }
                    // Jika tidak upload file baru, biarkan nilai lama
                } else {
                    $config->value = $value;
                }

                $config->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Konfigurasi berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui konfigurasi: ' . $e->getMessage()
            ], 500);
        }
    }


    public function destroy($id)
    {
        try {
            $config = Config::findOrFail($id);

            // Delete image if exists
            if ($config->type === 'image' && $config->value && Storage::disk('public')->exists($config->value)) {
                Storage::disk('public')->delete($config->value);
            }

            $config->delete();

            return response()->json([
                'success' => true,
                'message' => 'Konfigurasi berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus konfigurasi: ' . $e->getMessage()
            ], 500);
        }
    }
}
