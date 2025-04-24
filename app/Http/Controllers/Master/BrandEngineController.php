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

    public function edit($id)
    {
        $brandEngine = $this->brandEngine->find($id);

        if (!$brandEngine) {
            return back()->with('error', 'Brand Engine not found.');
        }

        return view('admin.pages.master.brand_engine.edit', compact('brandEngine'));
    }
    public function update(Request $request, $id)
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
            $brandEngine = $this->brandEngine->find($id);

            if (!$brandEngine) {
                DB::rollBack();
                return back()->with('error', 'Brand Engine not found.');
            }

            $brandEngine->update([
                'name' => $request->name,
            ]);

            DB::commit();
            return back()->with('success', 'Brand Engine has been updated successfully.');
        } catch (\Exception) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong while updating.');
        }
    }
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $brandEngine = $this->brandEngine->find($id);

            if (!$brandEngine) {
                DB::rollBack();
                return back()->with('error', 'Brand Engine not found.');
            }

            $brandEngine->delete();

            DB::commit();
            return back()->with('success', 'Brand Engine has been deleted successfully.');
        } catch (\Exception) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong while deleting.');
        }
    }
}
