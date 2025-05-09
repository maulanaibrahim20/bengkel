<?php

namespace App\Http\Controllers;

use App\Facades\GenerateQrCode;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
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
            ->editColumn('booking_code', function ($row) {
                return '<strong class="qrBtn badge bg-light text-primary" role="button" data-code="' . $row->booking_code . '">
                            ' . e($row->booking_code) . '
                        </strong>';
            })
            ->editColumn('status', function ($row) {
                $status = $row->status;
                if ($status === 'pending') {
                    return '<span class="badge bg-warning text-dark">Pending</span>';
                } elseif ($status === 'confirmed') {
                    return '<span class="badge" style="background-color: #0d6efd;">Confirmed</span>';
                } elseif ($status === 'registered') {
                    return '<span class="badge" style="background-color: #198754;">Registered</span>';
                } elseif ($status === 'cancelled') {
                    return '<span class="badge" style="background-color: #dc3545;">Cancelled</span>';
                } else {
                    return '<span class="badge bg-secondary">Unknown</span>';
                }
            })
            ->addColumn('action', function ($row) {
                return '<button type="button" class="btn btn-warning btn-sm editBtn" data-id="' . $row->id . '">
                        <i class="fa fa-eye"></i> Detail
                    </button>';
            })
            ->rawColumns(['booking_code', 'status', 'action'])
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

        $slotDate = Carbon::parse($booking->slot->date);
        $formattedDate = $slotDate->locale('id')->isoFormat('dddd, DD-MM-YYYY');
        $formattedTime = Carbon::parse($booking->slot->time)->format('H:i') . ' WIB';

        $qrCode = GenerateQrCode::generateBookingQrCode($booking->booking_code);

        return response()->json([
            'booking' => $booking,
            'slot' => [
                'date' => $formattedDate,
                'time' => $formattedTime,
            ],
            'services' => $booking->services,
            'qrCodeUrl' => $qrCode,
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

        if ($request->status === 'cancelled') {
            $booking->cancellation_reason = $request->reason;
        }

        $booking->save();

        return response()->json(['message' => 'Status updated successfully.']);
    }

    public function qrView($bookingCode)
    {
        $booking = Booking::where('user_id', Auth::id())
            ->where('booking_code', $bookingCode)
            ->firstOrFail();

        $qrUrl = GenerateQrCode::generateBookingQrCode($booking->booking_code);

        return view('user.pages.booking_history.qr-view-modal', compact('booking', 'qrUrl'));
    }

    public function confirmViaWhatsApp(Request $request)
    {
        $booking = Booking::where('booking_code', $request->booking_code)->first();

        if (!$booking) {
            return response()->json(['success' => false, 'message' => 'Booking tidak ditemukan.']);
        }

        $booking->status = 'confirmed';
        $booking->save();

        return response()->json(['success' => true]);
    }
}
