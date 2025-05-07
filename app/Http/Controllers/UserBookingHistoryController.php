<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class UserBookingHistoryController extends Controller
{

    public function getDataTable(Request $request)
    {
        $query = Booking::with(['slot', 'services'])
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at');

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('created_at', function ($row) {
                return $row->created_at->translatedFormat('d M Y H:i');
            })
            ->editColumn('status', function ($row) {
                $status = $row->status;
                if ($status === 'pending') {
                    return '<span class="badge bg-warning text-dark">Pending</span>';
                } elseif ($status === 'confirmed') {
                    return '<span class="badge bg-success">Confirmed</span>';
                } else {
                    return '<span class="badge bg-secondary">Cancelled</span>';
                }
            })
            ->addColumn('action', function ($row) {
                return '<button type="button" class="btn btn-warning btn-sm editBtn" data-id="' . $row->id . '">
                        <i class="fa fa-eye"></i> Detail
                    </button>';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }
    public function index()
    {
        $bookings = Booking::with(['slot', 'services'])
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        return view('user.pages.booking_history.index', compact('bookings'));
    }

    public function show($id)
    {
        $booking = Booking::with(['slot', 'services'])
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return response()->json([
            'booking' => $booking,
            'slot' => $booking->slot,
            'services' => $booking->services
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:confirmed,cancelled',
            'reason' => 'required_if:status,cancelled'
        ]);

        $booking = Booking::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();


        $booking->status = $request->status;

        // Simpan alasan pembatalan jika ada
        if ($request->status === 'cancelled') {
            $booking->cancellation_reason = $request->reason;
        }

        $booking->save();

        return response()->json(['message' => 'Status updated successfully.']);
    }
}
