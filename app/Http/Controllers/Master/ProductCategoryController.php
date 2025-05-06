<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ProductCategoryController extends Controller
{
    protected $productCategory;

    public function __construct()
    {
        $this->productCategory = new ProductCategory();
    }

    public function getDataTable(Request $request)
    {
        $data = $this->productCategory->select(['id', 'name']);

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $editBtn = "<button type='button' class='btn br-7 btn-warning editBtn' data-id='{$row->id}' data-bs-toggle='modal' data-bs-target='#add_salary-edit'><i class='fas fa-edit'></i></button>";

                $deleteForm = "<form id='deleteForm{$row->id}' action='" . url("/super-admin/master/product-category/{$row->id}/delete") . "' method='POST' style='display: inline;'>
                    " . csrf_field() . method_field('DELETE') . "
                    <button type='submit' class='btn btn-danger deleteBtn' data-id='{$row->id}'><i class='fas fa-trash'></i></button>
                </form>";

                return $editBtn . ' ' . $deleteForm;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function index()
    {
        return view('super-admin.pages.master.product_category.index');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json(['message' => $validator->errors()->first()], 422);
            }

            return back()->with('error', $validator->errors()->first());
        }

        try {
            $this->productCategory->create([
                'name' => $request->name,
            ]);

            DB::commit();

            if ($request->ajax()) {
                return response()->json(['message' => 'Product Category berhasil ditambahkan.']);
            }

            return back()->with('success', 'Product Category berhasil ditambahkan.');
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
        $data['productCategory'] = $this->productCategory->find($id);

        if (!$data['productCategory']) {
            return back()->with('error', 'Brand Engine not found.');
        }

        return view('super-admin.pages.master.product_category.edit', $data);
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            DB::rollBack();
            return back()->with('error', $validator->errors()->first());
        }

        try {
            $productCategory = $this->productCategory->find($id);

            if (!$productCategory) {
                DB::rollBack();
                return back()->with('error', 'Product Category not found.');
            }

            $productCategory->update([
                'name' => $request->name,
            ]);

            DB::commit();
            return back()->with('success', 'Product Category has been updated successfully.');
        } catch (\Exception) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong while updating.');
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $productCategory = $this->productCategory->find($id);

            if (!$productCategory) {
                DB::rollBack();
                return response()->json(['error' => 'Product category not found.'], 404);
            }

            $productCategory->delete();

            DB::commit();
            return response()->json(['success' => 'Product category has been deleted successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Something went wrong while deleting.'], 500);
        }
    }
}
