<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Technician;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class TechnicianController extends Controller
{
    protected $technician;

    public function __construct(Technician $technician)
    {
        $this->technician = $technician;
    }

    public function getDataTable(Request $request)
    {
        $data = $this->technician->select(['id', 'name', 'username']);

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $editBtn = "<button type='button' class='btn br-7 btn-warning editBtn' data-id='{$row->id}' data-bs-toggle='modal' data-bs-target='#add_salary-edit'><i class='fa fa-edit'></i></button>";

                $deleteForm = "<form id='deleteForm{$row->id}' action='" . url("/super-admin/master/technician/{$row->id}/delete") . "' method='POST' style='display: inline;'>
                " . csrf_field() . method_field('DELETE') . "
                <button type='submit' class='btn btn-danger deleteBtn' data-id='{$row->id}'><i class='fa fa-trash'></i></button>
            </form>";

                return $editBtn . ' ' . $deleteForm;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function index()
    {
        $data['technicians'] = $this->technician->latest()->get();
        return view('super-admin.pages.master.technician.index', $data);
    }

    public function create()
    {
        return view('super-admin.pages.master.technician.create');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'username' => 'required|string|max:50|unique:technicians,username',
        ]);

        if ($validator->fails()) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json(['message' => $validator->errors()->first()], 422);
            }

            return back()->with('error', $validator->errors()->first());
        }

        try {
            $this->technician->create([
                'name' => $request->name,
                'username' => $request->username,
            ]);
            DB::commit();

            if ($request->ajax()) {
                return response()->json(['message' => 'Brand Engine berhasil ditambahkan.']);
            }

            return back()->with('success', 'Brand Engine berhasil ditambahkan.');
        } catch (\Exception) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json(['message' => 'Terjadi kesalahan saat menyimpan data.'], 500);
            }

            return back()->with('error', 'Something went wrong.');
        }
    }

    public function edit($id)
    {
        $data['technician'] = $this->technician->find($id);

        if (!$data['technician']) {
            return back()->with('error', 'Technician not found.');
        }

        return view('super-admin.pages.master.technician.edit', $data);
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'username' => 'required|string|max:50|unique:technicians,username,' . $id,
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
                return response()->json(['error', 'Technician not found.'], 400);
            }

            $technician->delete();

            DB::commit();
            return response()->json(['success', 'Technician has been deleted successfully.']);
        } catch (\Exception) {
            DB::rollBack();
            return response()->json(['error', 'Something went wrong while deleting.']);
        }
    }

    public function checkUsername(Request $request)
    {
        $username = $request->query('username');
        $exists = $this->technician->where('username', $username)->exists();
        return response()->json(['exists' => $exists]);
    }
}
