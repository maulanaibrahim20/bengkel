<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Technician;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TechnicianController extends Controller
{
    protected $technician;

    public function __construct(Technician $technician)
    {
        $this->technician = $technician;
    }

    public function index()
    {
        $data['technicians'] = $this->technician->latest()->get();
        return view('admin.pages.master.technician.index', $data);
    }

    public function create()
    {
        return view('admin.pages.master.technician.create');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:technicians,username',
        ]);

        if ($validator->fails()) {
            DB::rollBack();
            return back()->with('error', $validator->errors()->first());
        }

        try {
            $this->technician->create([
                'name' => $request->name,
                'username' => $request->username,
            ]);
            DB::commit();
            return back()->with('success', 'Technician has been created successfully.');
        } catch (\Exception) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong.');
        }
    }

    public function edit($id)
    {
        $data['technician'] = $this->technician->find($id);

        if (!$data['technician']) {
            return back()->with('error', 'Technician not found.');
        }

        return view('admin.pages.master.technician.edit', $data);
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:technicians,username,' . $id,
        ]);

        if ($validator->fails()) {
            DB::rollBack();
            return back()->with('error', $validator->errors()->first());
        }

        try {
            $technician = $this->technician->find($id);

            if (!$technician) {
                DB::rollBack();
                return back()->with('error', 'Technician not found.');
            }

            $technician->update([
                'name' => $request->name,
                'username' => $request->username,
            ]);

            DB::commit();
            return back()->with('success', 'Technician has been updated successfully.');
        } catch (\Exception) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong while updating.');
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $technician = $this->technician->find($id);

            if (!$technician) {
                DB::rollBack();
                return back()->with('error', 'Technician not found.');
            }

            $technician->delete();

            DB::commit();
            return back()->with('success', 'Technician has been deleted successfully.');
        } catch (\Exception) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong while deleting.');
        }
    }

    public function checkUsername(Request $request)
    {
        $username = $request->query('username');
        $exists = $this->technician->where('username', $username)->exists();
        return response()->json(['exists' => $exists]);
    }
}
