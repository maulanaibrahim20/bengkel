<?php

namespace App\Http\Controllers;

use App\Models\Motorcycle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class MotorCycleAdminController extends Controller
{
    public function getDataTable(Request $request)
    {
        $query = Motorcycle::with(['user', 'brandEngine'])->select('motorcycles.*');


        $isSuperAdmin = Auth::user()->can('super-admin');

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('user', fn($row) => $row->user->name ?? '-')
            ->addColumn('brand', fn($row) => $row->brandEngine->name ?? '-')
            ->addColumn('type', fn($row) => $row->type)
            ->addColumn('plate', fn($row) => $row->plate)
            ->addColumn('action', function ($row) use ($isSuperAdmin) {
                if ($isSuperAdmin) {
                    return '-'; // Tidak ada aksi
                }

                $editUrl = url('admin.motorcycle.edit', $row->id);
                $deleteUrl = url('admin.motorcycle.destroy', $row->id);

                return "
                <a href='{$editUrl}' class='btn btn-sm btn-warning'><i class='fas fa-edit'></i></a>
                <form action='{$deleteUrl}' method='POST' style='display:inline'>
                    " . csrf_field() . method_field('DELETE') . "
                    <button class='btn btn-sm btn-danger'><i class='fas fa-trash'></i></button>
                </form>
            ";
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function index()
    {
        return view('super-admin.pages.motorcycle.index');
    }
}
