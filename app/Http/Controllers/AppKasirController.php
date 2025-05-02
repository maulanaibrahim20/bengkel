<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AppKasirController extends Controller
{
    protected $product, $category;

    public function __construct()
    {
        $this->product = new Product();
        $this->category = new ProductCategory();
    }

    public function getData(Request $request)
    {
        $query = Product::with('category', 'unit');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('code', 'like', "%$search%");
            });
        }

        return DataTables::of($query)
            ->addColumn('price_formatted', function ($row) {
                return 'Rp ' . number_format($row->price, 0, ',', '.');
            })
            ->make(true);
    }

    public function index()
    {
        $data = [
            'product' => $this->product->all(),
            'category' => $this->category->all()
        ];
        return view('super-admin.kasir.index', $data);
    }
}
