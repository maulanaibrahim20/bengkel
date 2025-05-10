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
            ->addColumn('user_name', function ($row) {
                return '<span class="text-dark fw-medium">' . ($row->user->name ?? '-') . '</span>';
            })
            ->addColumn('booking_code', function ($row) {
                return '<a href="#" class="show-qr text-primary fw-medium" data-id="' . $row->id . '">
                            <i class="la la-qr-code me-1"></i>' . e($row->booking_code) .
                    '</a>';
            })
            ->addColumn('schedule', function ($row) {
                if (!$row->slot) return '<span class="text-muted">-</span>';

                return '<div>' .
                    '<span class="text-dark d-block">' . date('d M Y', strtotime($row->slot->date)) . '</span>' .
                    '<small class="text-muted">' . date('H:i', strtotime($row->slot->time)) . ' WIB</small>' .
                    '</div>';
            })
            ->addColumn('vehicle', function ($row) {
                $motor = $row->motorCycleDetail->motorcycle ?? null;
                if (!$motor) return '<span class="text-muted">-</span>';

                return '<a href="#" class="show-vehicle text-dark" data-id="' . $motor->id . '">
                            <div class="d-flex align-items-center">
                                <span class="bg-light p-1 px-2 rounded me-2 text-primary fw-medium">' . e($motor->plate) . '</span>
                                <small>' . e($motor->type) . '</small>
                            </div>
                        </a>';
            })
            ->addColumn('services', function ($row) {
                if ($row->bookingServices->isEmpty()) return '<span class="text-muted">-</span>';

                $count = $row->bookingServices->count();
                $firstService = $row->bookingServices->first()->service->name ?? '';

                return '<a href="#" class="show-services text-dark" data-id="' . $row->id . '">
                            <span class="d-block">' . e($firstService) . '</span>' .
                    ($count > 1 ? '<small class="text-primary">+' . ($count - 1) . ' layanan lainnya</small>' : '') .
                    '</a>';
            })
            ->addColumn('detail_service', function ($row) {
                $detail = $row->motorCycleDetail;
                if (!$detail) return '<span class="text-muted">-</span>';

                return '<a href="#" class="show-detail-service btn btn-sm rounded-pill" data-id="' . $detail->id . '">
                            <i class="la la-info-circle me-1"></i>Detail
                        </a>';
            })
            ->addColumn('status', function ($row) {
                $statusClass = $this->getStatusBadgeClass($row->status);
                return '<span class="badge ' . $statusClass . '">' . ucfirst($row->status) . '</span>';
            })
            ->rawColumns(['user_name', 'booking_code', 'schedule', 'vehicle', 'services', 'detail_service', 'status'])
            ->make(true);
    }

    // Fungsi helper untuk menentukan class badge berdasarkan status
    private function getStatusBadgeClass($status)
    {
        switch (strtolower($status)) {
            case 'pending':
                return 'bg-warning text-dark';
            case 'confirmed':
                return 'bg-info text-dark';
            case 'completed':
                return 'bg-success';
            case 'cancelled':
                return 'bg-danger';
            case 'in progress':
                return 'bg-primary';
            default:
                return 'bg-secondary';
        }
    }

    public function getQrCode($id)
    {
        $booking = Booking::with('user')->findOrFail($id);
        $qr = GenerateQrCode::generateBookingQrCode($booking->booking_code);
        $booking_code = $booking->booking_code;

        return response()->json([
            'html' => view('super-admin.pages.booking_list.booking_code', compact('qr', 'booking_code'))->render()
        ]);
    }

    public function getMotorcycleDetail($id)
    {
        $motorcycle = Motorcycle::with(['user', 'brandEngine', 'latestMotorCycleDetail'])->findOrFail($id);

        return response()->json([
            'html' => view('super-admin.pages.booking_list.motorcycle_detail', compact('motorcycle'))->render()
        ]);
    }

    public function getBookingServices($id)
    {
        $booking = Booking::with('bookingServices.service.detail')->findOrFail($id);
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

    public function updateMotorcycleServiceDetail(Request $request, $id)
    {
        $request->validate([
            'year_of_manufacture' => 'nullable|integer',
            'kilometer_before' => 'nullable|integer',
            'oil_before' => 'nullable|string',
            'kilometer_after' => 'nullable|integer',
            'oil_after' => 'nullable|string',
        ]);

        try {
            $detail = MotorCycleDetails::findOrFail($id);
            $detail->update([
                'year_of_manufacture' => $request->year_of_manufacture,
                'kilometer_before' => $request->kilometer_before,
                'oil_before' => $request->oil_before,
                'kilometer_after' => $request->kilometer_after,
                'oil_after' => $request->oil_after,
            ]);

            return response()->json(['success' => true, 'message' => 'Data servis motor berhasil diperbarui.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal memperbarui data.', 'error' => $e->getMessage()], 500);
        }
    }
}
