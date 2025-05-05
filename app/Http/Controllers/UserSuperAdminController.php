<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UserSuperAdminController extends Controller
{
    protected $user;
    public function __construct()
    {
        $this->user = new User();
    }

    public function getDataTable(Request $request)
    {
        $data = $this->user->with('role');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('status', fn($row) => $row->status ? 'Active' : 'Inactive')
            ->addColumn('role', fn($row) => $row->role ? $row->role->name : '-')
            ->addColumn('action', function ($row) {
                $editBtn = "<button type='button' class='btn btn-warning btn-sm editBtn' data-id='{$row->id}'><i class='fa fa-edit'></i></button>";

                $deleteForm = "<form id='deleteForm{$row->id}' action='" . url("/super-admin/user/{$row->id}/delete") . "' method='POST' style='display: inline;'>
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
        $data['role'] = Roles::all();
        return view('super-admin.pages.user.index', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:50',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|string|min:8',
            'phone'     => 'nullable|string|max:15',
            'role_id'   => 'required|exists:roles,id',
            'status'    => 'required|in:0,1', // 0 = inactive, 1 = active
        ]);

        if ($validator->fails()) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json(['message' => $validator->errors()->first()], 422);
            }

            return back()->with('error', $validator->errors()->first());
        }

        DB::beginTransaction();

        try {
            $this->user->create([
                'name'        => $request->name,
                'email'       => $request->email,
                'password'    => bcrypt($request->password),
                'phone'       => $request->phone,
                'role_id'     => $request->role_id,
                'status'      => $request->status,
            ]);

            DB::commit();

            if ($request->ajax()) {
                return response()->json(['message' => 'Data user berhasil disimpan.']);
            }

            return back()->with('success', 'Data user berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json(['message' => 'Terjadi kesalahan saat menyimpan data.'], 500);
            }

            return back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function edit($id)
    {
        $user = $this->user->with('role')->findOrFail($id);
        $roles = Roles::all();

        return view('super-admin.pages.user.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:50',
            'email'     => 'required|email|unique:users,email,' . $id,
            'password'  => 'nullable|string|min:8',
            'phone'     => 'nullable|string|max:15',
            'role_id'   => 'required|exists:roles,id',
            'status'    => 'required|in:0,1',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['message' => $validator->errors()->first()], 422);
            }

            return back()->with('error', $validator->errors()->first());
        }

        $user = User::findOrFail($id);
        DB::beginTransaction();

        try {
            $data = [
                'name'      => $request->name,
                'email'     => $request->email,
                'phone'     => $request->phone,
                'role_id'   => $request->role_id,
                'status'    => $request->status,
            ];

            if ($request->filled('password')) {
                $data['password'] = bcrypt($request->password);
            }

            $user->update($data);

            DB::commit();

            if ($request->ajax()) {
                return response()->json(['message' => 'Data user berhasil diperbarui.']);
            }

            return back()->with('success', 'Data user berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json(['message' => 'Terjadi kesalahan saat memperbarui data.'], 500);
            }

            return back()->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $user = $this->user->find($id);

            if (!$user) {
                DB::rollBack();
                return response()->json(['error', 'Pengguna not found.'], 400);
            }

            $user->delete();

            DB::commit();
            return response()->json(['success', 'Technician has been deleted successfully.']);
        } catch (\Exception) {
            DB::rollBack();
            return response()->json(['error', 'Something went wrong while deleting.']);
        }
    }
}
