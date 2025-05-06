<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\ProductUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ProductUnitController extends Controller
{
    protected $productUnit;

    public function __construct()
    {
        $this->productUnit = new ProductUnit();
    }

    public function index()
    {
        return view('super-admin.pages.master.product_unit.index');
    }

    public function getDataTable(Request $request)
    {
        $data = $this->productUnit->select(['id', 'name', 'acronym']);

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $editBtn = "<button type='button' class='btn br-7 btn-warning editBtn' data-id='{$row->id}' data-bs-toggle='modal' data-bs-target='#editModal'><i class='fas fa-edit'></i></button>";

                $deleteForm = "<form id='deleteForm{$row->id}' action='" . url("/super-admin/master/product-unit/{$row->id}/delete") . "' method='POST' style='display: inline;'>
                    " . csrf_field() . method_field('DELETE') . "
                    <button type='submit' class='btn btn-danger deleteBtn' data-id='{$row->id}'><i class='fas fa-trash'></i></button>
                </form>";

                return $editBtn . ' ' . $deleteForm;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'acronym' => 'required|string|max:10',
        ]);

        if ($validator->fails()) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json(['message' => $validator->errors()->first()], 422);
            }

            return back()->with('error', $validator->errors()->first());
        }

        try {
            $this->productUnit->create([
                'name' => $request->name,
                'acronym' => $request->acronym,
            ]);

            DB::commit();

            if ($request->ajax()) {
                return response()->json(['message' => 'Satuan Produk berhasil ditambahkan.']);
            }

            return back()->with('success', 'Satuan Produk berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json(['message' => 'Terjadi kesalahan saat menyimpan data.' . $e->getMessage()], 500);
            }

            return back()->with('error', 'Terjadi kesalahan saat menyimpan data.' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $data['productUnit'] = $this->productUnit->find($id);

        if (!$data['productUnit']) {
            return back()->with('error', 'Satuan Produk tidak ditemukan.');
        }

        return view('super-admin.pages.master.product_unit.edit', $data);
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'acronym' => 'required|string|max:10',
        ]);

        if ($validator->fails()) {
            DB::rollBack();
            return back()->with('error', $validator->errors()->first());
        }

        try {
            $productUnit = $this->productUnit->find($id);

            if (!$productUnit) {
                DB::rollBack();
                return back()->with('error', 'Satuan Produk tidak ditemukan.');
            }

            $productUnit->update([
                'name' => $request->name,
                'acronym' => $request->acronym,
            ]);

            DB::commit();
            return back()->with('success', 'Satuan Produk berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $productUnit = $this->productUnit->find($id);

            if (!$productUnit) {
                DB::rollBack();
                return response()->json(['error' => 'Satuan Produk tidak ditemukan.'], 404);
            }

            $productUnit->delete();

            DB::commit();
            return response()->json(['success' => 'Satuan Produk berhasil dihapus.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Terjadi kesalahan saat menghapus data.'], 500);
        }
    }
}
