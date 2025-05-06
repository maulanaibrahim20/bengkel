<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServiceRequest;
use App\Models\Service;
use App\Models\ServiceDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ServiceController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = new Service();
    }
    public function getDataTable(Request $request)
    {
        $data = $this->service->select(['id', 'name', 'price', 'duration']);

        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('price', function ($row) {
                return 'Rp ' . number_format($row->price, 0, ',', '.');
            })
            ->addColumn('action', function ($row) {
                $detailBtn = "<button type='button' class='btn btn-info btn detailBtn' data-id='{$row->id}'><i class='fa fa-eye'></i></button>";

                $editBtn = "<a href='" . url('super-admin/service/' . $row->id . '/edit') . "' class='btn btn-warning'><i class='fa fa-edit'></i></a>";

                $deleteForm = "<form id='deleteForm{$row->id}' action='" . url("/super-admin/services/{$row->id}/delete") . "' method='POST' style='display:inline-block;'>
                    " . csrf_field() . method_field('DELETE') . "
                    <button type='submit' class='btn btn-danger btn deleteBtn' data-id='{$row->id}'><i class='fa fa-trash'></i></button>
                </form>";

                return $detailBtn . ' ' . $editBtn . ' ' . $deleteForm;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function index()
    {
        return view('super-admin.pages.service.index');
    }

    public function getDetails($id)
    {
        $service = $this->service->with('detail')->findOrFail($id);

        return view('super-admin.pages.service.detail', compact('service'));
    }

    public function create()
    {
        return view('super-admin.pages.service.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'duration' => 'required|string|max:100',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'details' => 'required|array|min:1',
            'details.*' => 'required|string|max:255',
        ], [
            'details.required' => 'Deskripsi layanan tidak boleh kosong!',
            'details.*.required' => 'Semua deskripsi layanan harus diisi!',
        ]);

        DB::beginTransaction();

        try {
            $service = $this->service->create([
                'name' => $request->name,
                'price' => $request->price,
                'duration' => $request->duration,
                'icon' => $request->hasFile('icon')
                    ? $request->file('icon')->store('icons', 'public')
                    : null,
            ]);

            foreach ($request->details as $desc) {
                $service->detail()->create([
                    'description' => $desc
                ]);
            }

            DB::commit();

            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }


    public function edit($id)
    {
        $service = $this->service->with('detail')->findOrFail($id);
        return view('super-admin.pages.service.edit', compact('service'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'duration' => 'required|string|max:100',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'details' => 'required|array|min:1',
            'details.*' => 'required|string|max:255',
        ], [
            'details.required' => 'Deskripsi layanan tidak boleh kosong!',
            'details.*.required' => 'Semua deskripsi layanan harus diisi!',
        ]);

        DB::beginTransaction();

        try {
            $service = $this->service->findOrFail($id);

            $service->update([
                'name' => $request->name,
                'price' => $request->price,
                'duration' => $request->duration,
                'icon' => $request->hasFile('icon')
                    ? $request->file('icon')->store('icons', 'public')
                    : $service->icon,
            ]);

            $service->detail()->delete();

            foreach ($request->details as $desc) {
                $service->detail()->create(['description' => $desc]);
            }

            DB::commit();

            return response()->json(['success' => true]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
