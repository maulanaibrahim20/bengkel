<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    protected $product, $category, $unit;

    public function __construct()
    {
        $this->product = new Product();
        $this->category = new ProductCategory();
        $this->unit = new ProductUnit();
    }

    public function getDataTable(Request $request)
    {
        $data = $this->product->with(['unit', 'category'])->select([
            'id',
            'name',
            'unit_id',
            'category_id',
            'code',
            'description',
            'stock',
            'image',
            'status'
        ]);

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('unit', fn($row) => $row->unit->name ?? '-')
            ->addColumn('category', fn($row) => $row->category->name ?? '-')
            ->addColumn('image', function ($row) {
                if ($row->image) {
                    $url = asset('storage/' . $row->image);
                    return "<img src='{$url}' width='60' height='60' class='img-thumbnail'>";
                }
                return '-';
            })
            ->addColumn('status', function ($row) {
                $badgeClass = $row->status === 'active' ? 'badge-success' : 'badge-danger';
                return "<span class='badge {$badgeClass} text-capitalize'>{$row->status}</span>";
            })
            ->addColumn('action', function ($row) {
                $editBtn = "<a href='" . url("/super-admin/product/{$row->id}/edit") . "' class='btn btn-warning btn-sm'><i class='fa fa-edit'></i></a>";

                $deleteBtn = "<button type='button' class='btn btn-danger btn-sm deleteBtn' data-id='{$row->id}'><i class='fa fa-trash'></i></button>";

                return $editBtn . ' ' . $deleteBtn;
            })
            ->rawColumns(['image', 'status', 'action'])
            ->make(true);
    }


    public function index()
    {
        return view('super-admin.pages.product.index');
    }

    public function create()
    {
        $data = [
            'category' => $this->category->all(),
            'unit' => $this->unit->all(),
        ];
        return view('super-admin.pages.product.create', $data);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'code' => 'required|string|max:50|unique:products,code',
            'category_id' => 'required|exists:product_categories,id',
            'unit_id' => 'required|exists:product_units,id',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        DB::beginTransaction();

        try {
            $imagePath = null;

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('products', 'public');
            }

            $this->product->create([
                'name' => $request->name,
                'code' => $request->code,
                'category_id' => $request->category_id,
                'unit_id' => $request->unit_id,
                'stock' => $request->stock,
                'status' => $request->status,
                'description' => $request->description,
                'image' => $imagePath,
            ]);

            DB::commit();

            return response()->json(['message' => 'Produk berhasil disimpan.'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $data = [
            'product' => $this->product->find($id),
            'category' => $this->category->all(),
            'unit' => $this->unit->all()
        ];

        return view('super-admin.pages.product.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'code' => 'required|string',
            'category_id' => 'required|exists:product_categories,id',
            'unit_id' => 'required|exists:product_units,id',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $product = $this->product->findOrFail($id);

            $product->update([
                'name' => $request->name,
                'code' => $request->code,
                'category_id' => $request->category_id,
                'unit_id' => $request->unit_id,
                'stock' => $request->stock,
                'status' => $request->status,
                'description' => $request->description
            ]);

            if ($request->hasFile('image')) {
                if ($product->image) {
                    Storage::delete('public/' . $product->image);
                }
                $imagePath = $request->file('image')->store('product-images', 'public');
                $product->update(['image' => $imagePath]);
            }

            DB::commit();
            return response()->json([
                'message' => 'Produk berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui produk.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $product = $this->product->findOrFail($id);

            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $product->delete();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Produk berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus produk: ' . $e->getMessage()
            ], 500);
        }
    }
}
