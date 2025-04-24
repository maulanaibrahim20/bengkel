<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\BrandEngine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BrandEngineController extends Controller
{
    protected $brandEngine;

    public function __construct()
    {
        $this->brandEngine = new BrandEngine();
    }

    public function index()
    {
        $data = [
            'brandEngine' => $this->brandEngine->all()
        ];
        return view('admin.pages.master.brand_engine.index', $data);
    }

    public function create(Request $request)
    {
        return view('admin.pages.master.brand_engine.create');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            DB::rollBack();
            return back()->with('error', $validator->errors()->first());
        }

        try {
            $this->brandEngine->create([
                'name' => $request->name,
            ]);
            DB::commit();
            return back()->with('success', 'Brand Engine has been created successfully.');
        } catch (\Exception) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong.');
        }
    }
}
