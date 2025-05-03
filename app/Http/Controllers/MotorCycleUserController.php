<?php

namespace App\Http\Controllers;

use App\Models\BrandEngine;
use App\Models\Motorcycle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class MotorCycleUserController extends Controller
{
    protected $motor, $brandEngine;

    public function __construct()
    {
        $this->motor = new Motorcycle();
        $this->brandEngine = new BrandEngine();
    }

    public function getDataTable(Request $request)
    {
        $data = Motorcycle::with(['user', 'brandEngine'])->select('motorcycles.*')->where('user_id', Auth::user()->id);

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('name', function ($row) {
                return "{$row->user->name} - {$row->brandEngine->name}";
            })
            ->addColumn('type', function ($row) {
                return $row->type;
            })
            ->addColumn('plate', function ($row) {
                return $row->plate;
            })
            ->addColumn('action', function ($row) {
                $editBtn = "<button type='button' class='btn btn-warning btn-sm editBtn'
                                data-id='{$row->id}'>
                                <i class='fa fa-edit'></i>
                            </button>";

                $deleteForm = "<form id='deleteForm{$row->id}' action='" . url("/user/motorcycle/{$row->id}/delete") . "' method='POST' style='display:inline;'>
                            " . csrf_field() . method_field('DELETE') . "
                            <button type='submit' class='btn btn-danger btn-sm deleteBtn' data-id='{$row->id}'><i class='fa fa-trash'></i></button>
                            </form>";


                return $editBtn . ' ' . $deleteForm;
            })

            ->rawColumns(['action'])
            ->make(true);
    }

    public function index()
    {
        $data = ['brands' =>  $this->brandEngine->all()];
        return view('user.pages.motorcyle.index', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'brand_id'     => 'required|exists:brand_engines,id',
            'type'         => 'required|string|max:50',
            'plate_prefix' => 'required|string|max:2',
            'plate_number' => 'required|numeric|digits_between:4,5',
            'plate_suffix' => 'required|string|max:3',
        ]);

        if ($validator->fails()) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json(['message' => $validator->errors()->first()], 422);
            }

            return back()->with('error', $validator->errors()->first());
        }

        $plate = strtoupper($request->plate_prefix) . ' ' . $request->plate_number . ' ' . strtoupper($request->plate_suffix);

        $exists = Motorcycle::where('plate', $plate)->exists();
        if ($exists) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Plat nomor sudah terdaftar.'
                ], 422);
            }
            return back()->with('error', 'Plat nomor sudah terdaftar.');
        }

        DB::beginTransaction();

        try {
            $this->motor->create([
                'user_id'   => Auth::user()->id,
                'brand_id'  => $request->brand_id,
                'type'      => $request->type,
                'plate'     => $plate,
            ]);

            DB::commit();

            if ($request->ajax()) {
                return response()->json(['message' => 'Data motor berhasil disimpan.']);
            }

            return back()->with('success', 'Data motor berhasil disimpan.');
        } catch (\Exception $e) {

            DB::rollBack();

            if ($request->ajax()) {
                return response()->json(['message' => 'Terjadi kesalahan saat menyimpan data.'], 500);
            }

            return back()->with('error', 'Something went wrong.');
        }
    }

    public function edit($id)
    {
        $motorcycle = Motorcycle::with('brandEngine')->findOrFail($id);
        $brands = BrandEngine::all(); // untuk select option brand

        // Pisahkan plat menjadi 3 bagian
        $plateParts = explode(' ', $motorcycle->plate);
        $plate_prefix = $plateParts[0] ?? '';
        $plate_number = $plateParts[1] ?? '';
        $plate_suffix = $plateParts[2] ?? '';

        return view('user.pages.motorcyle.edit', compact(
            'motorcycle',
            'brands',
            'plate_prefix',
            'plate_number',
            'plate_suffix'
        ));
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'brand_id'     => 'required|exists:brand_engines,id',
            'type'         => 'required|string|max:50',
            'plate_prefix' => 'required|string|max:2',
            'plate_number' => 'required|numeric|digits_between:4,5',
            'plate_suffix' => 'required|string|max:3',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['message' => $validator->errors()->first()], 422);
            }

            return back()->with('error', $validator->errors()->first());
        }

        $plate = strtoupper($request->plate_prefix) . ' ' . $request->plate_number . ' ' . strtoupper($request->plate_suffix);

        $motorcycle = $this->motor->findOrFail($id);

        $exists = $this->motor
            ->where('plate', $plate)
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Plat nomor sudah digunakan oleh motor lain.'
                ], 422);
            }

            return back()->with('error', 'Plat nomor sudah digunakan oleh motor lain.');
        }

        DB::beginTransaction();

        try {
            $motorcycle->update([
                'user_id'   => Auth::user()->id,
                'brand_id'  => $request->brand_id,
                'type'      => $request->type,
                'plate'     => $plate,
            ]);

            DB::commit();

            if ($request->ajax()) {
                return response()->json(['message' => 'Data motor berhasil diperbarui.']);
            }

            return back()->with('success', 'Data motor berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json(['message' => 'Terjadi kesalahan saat memperbarui data.'], 500);
            }

            return back()->with('error', 'Something went wrong.');
        }
    }

    public function destroy($id, Request $request)
    {
        DB::beginTransaction();

        try {
            $motor = Motorcycle::where('user_id', Auth::id())->findOrFail($id);
            $motor->delete();

            DB::commit();

            if ($request->ajax()) {
                return response()->json(['message' => 'Data motor berhasil dihapus.']);
            }

            return back()->with('success', 'Data motor berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json(['message' => 'Gagal menghapus data.'], 500);
            }

            return back()->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }
}
