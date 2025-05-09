<?php

namespace App\Http\Controllers;

use App\Facades\GenerateQrCode;
use App\Models\Booking;
use App\Models\Motorcycle;
use App\Models\MotorCycleDetails;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BookingListSuperAdminController extends Controller
{
    public function index()
    {
        return view('super-admin.pages.booking_list.index');
    }

    public function getDataTable()
    {
        $data = Booking::with([
            'user',
            'slot',
            'motorCycleDetail.motorcycle',
            'bookingServices.service'
        ])->latest();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('user_name', fn($row) => $row->user->name ?? '-')
            ->addColumn('booking_code', fn($row) => '<a href="#" class="show-qr" data-id="' . $row->id . '">' . e($row->booking_code) . '</a>')
            ->addColumn('schedule', function ($row) {
                return $row->slot
                    ? $row->slot->date . ' ' . $row->slot->time
                    : '-';
            })
            ->addColumn('vehicle', function ($row) {
                $motor = $row->motorCycleDetail->motorcycle ?? null;
                return $motor
                    ? '<a href="#" class="show-vehicle" data-id="' . $motor->id . '">' . e($motor->plate . ' - ' . $motor->type) . '</a>'
                    : '-';
            })
            ->addColumn('services', function ($row) {
                $services = $row->bookingServices->map(fn($bs) => $bs->service->name ?? '')->implode(', ');
                return '<a href="#" class="show-services" data-id="' . $row->id . '">' . e($services) . '</a>';
            })
            ->addColumn('detail_service', function ($row) {
                $detail = $row->motorCycleDetail;
                return $detail
                    ? '<a href="#" class="show-detail-service" data-id="' . $detail->id . '">Lihat Detail</a>'
                    : '-';
            })
            ->addColumn('status', fn($row) => ucfirst($row->status))
            ->rawColumns(['booking_code', 'vehicle', 'services', 'detail_service']) // penting!
            ->make(true);
    }

    public function getQrCode($id)
    {
        $booking = Booking::with('user')->findOrFail($id);
        $qrBase64 = GenerateQrCode::generateBookingQrCode($booking->booking_code);

        return response()->json([
            'qr' => $qrBase64,
            'booking_code' => $booking->booking_code
        ]);
    }

    public function getMotorcycleDetail($id)
    {
        $motorcycle = Motorcycle::with('user')->findOrFail($id);
        return response()->json([
            'html' => view('super-admin.pages.booking_list.motorcycle_detail', compact('motorcycle'))->render()
        ]);
    }

    public function getBookingServices($id)
    {
        $booking = Booking::with('bookingServices.service')->findOrFail($id);
        return response()->json([
            'html' => view('super-admin.pages.booking_list.booking_services', compact('booking'))->render()
        ]);
    }

    public function getMotorcycleServiceDetail($id)
    {
        $motorcycleDetail = MotorCycleDetails::with('motorcycle', 'booking')->findOrFail($id);
        return response()->json([
            'html' => view('super-admin.pages.booking_list.motorcycle_service_detail', compact('motorcycleDetail'))->render()
        ]);
    }
}
