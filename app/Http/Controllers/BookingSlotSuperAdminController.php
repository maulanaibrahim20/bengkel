<?php

namespace App\Http\Controllers;

use App\Models\BookingSlot;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class BookingSlotSuperAdminController extends Controller
{
    public function getDataTable(Request $request)
    {
        $groupedSlots = BookingSlot::select(
            DB::raw('DATE(date) as raw_date'),
            DB::raw('COUNT(*) as total_slots')
        )
            ->groupBy(DB::raw('DATE(date)'))
            ->orderByDesc(DB::raw('DATE(date)'))
            ->get();

        $groupedSlots->each(function ($slot) {
            $slot->formatted_date = Carbon::parse($slot->raw_date)->translatedFormat('l, d-F-Y');
        });

        return DataTables::of($groupedSlots)
            ->addColumn('action', function ($row) {
                return '
            <button class="btn btn-sm btn-info detailBtn" data-date="' . $row->date . '">Lihat Detail</button>
        ';
            })
            ->addColumn('date', function ($row) {
                return $row->formatted_date;
            })
            ->addColumn('raw_date', function ($row) {
                return $row->raw_date;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function index()
    {
        return view('super-admin.pages.booking.index');
    }

    public function getSlotDetailsByDate($date)
    {
        $slots = BookingSlot::where('date', $date)
            ->orderBy('time')
            ->get();

        dd($slots);

        return response()->json($slots);
    }
}
