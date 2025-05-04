<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class UserProfileController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function formRegister()
    {
        $user = $this->user->find(Auth::id());

        $nameParts = explode(' ', $user->name, 2);

        $data = [
            'user' => $user,
            'firstName' => $nameParts[0],
            'lastName' => $nameParts[1] ?? '',
            'wilayah' => Http::get('https://emsifa.github.io/api-wilayah-indonesia/api/provinces.json')->json(),
        ];

        return view('user.pages.form_register.index', $data);
    }

    public function update(Request $request)
    {
        DB::beginTransaction();

        try {
            $user = $this->user->find(Auth::user()->id);

            $user->update([
                'name' => Str::slug($request->first_name) . ' ' . Str::slug($request->last_name),
                'phone' => $request->phone,
                'status' => 1
            ]);

            DB::commit();

            return redirect('/user/welcome')->with('success', 'Profil berhasil diupdate.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/user/update/profile')->with('error', 'Profil gagal diupdate.');
        }
    }
}
