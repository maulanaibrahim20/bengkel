<?php

namespace App\Http\Controllers;

use App\Models\BookingSlot;
use App\Service\BookingSlotService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class BookingSlotSuperAdminController extends Controller
{
    protected $bookingSlot, $bookingSlotService;

    public function __construct()
    {
        $this->bookingSlot = new BookingSlot();
        $this->bookingSlotService = new BookingSlotService();
    }

    public function getDataTable(Request $request)
    {
        try {
            $groupedSlots = $this->bookingSlot->select(
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
                        <a href="' . url('super-admin/booking-slot/details-booking', ['date' => $row->raw_date]) . '" class="btn btn-sm btn-info">
                            Lihat Detail
                        </a>
                    ';
                })
                ->addColumn('date', function ($row) {
                    return $row->formatted_date;
                })
                ->addColumn('raw_date', function ($row) {
                    return $row->raw_date;
                })
                ->make(true);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat memuat data: ' . $e->getMessage()], 500);
        }
    }

    public function index()
    {
        try {
            return view('super-admin.pages.booking.index');
        } catch (\Exception $e) {
            return abort(500, 'Gagal membuka halaman.');
        }
    }

    public function showSlotDetailPage(Request $request, $date)
    {
        try {
            if ($request->ajax()) {
                $slots = $this->bookingSlot->where('date', $date)->orderBy('time')->get();

                return datatables()->of($slots)
                    ->addIndexColumn()
                    ->editColumn('time', fn($slot) => Carbon::parse($slot->time)->format('H:i'))
                    ->editColumn('status', function ($slot) {
                        if ($slot->current_bookings >= $slot->max_bookings) {
                            return '<span class="badge bg-danger">Penuh</span>';
                        } elseif ($slot->current_bookings > 0) {
                            return '<span class="badge bg-warning text-dark">Sebagian</span>';
                        } else {
                            return '<span class="badge bg-success">Kosong</span>';
                        }
                    })
                    ->editColumn('action', function ($slot) {
                        return '<button class="btn btn-sm btn-danger delete-slot-btn" data-id="' . $slot->id . '">
                                    <i class="la la-trash"></i>
                                </button>
                                <button class="btn btn-sm btn-warning edit-slot-btn" data-id="' . $slot->id . '"
                                    data-time="' . $slot->time . '" data-max-bookings="' . $slot->max_bookings . '">
                                    <i class="la la-pencil"></i>
                                </button>';
                    })
                    ->rawColumns(['status', 'action'])
                    ->make(true);
            }

            $date = Carbon::parse($date)->format('Y-m-d');
            return view('super-admin.pages.booking.detail', compact('date'));
        } catch (\Exception $e) {
            return abort(500, 'Gagal membuka detail slot: ' . $e->getMessage());
        }
    }

    public function create()
    {
        try {
            $disabledDates = $this->bookingSlot->select('date')
                ->distinct()
                ->pluck('date')
                ->map(fn($date) => Carbon::parse($date)->format('Y-m-d'))
                ->toArray();

            return view('super-admin.pages.booking.create', compact('disabledDates'));
        } catch (\Exception $e) {
            return abort(500, 'Gagal membuka halaman pembuatan slot.');
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'date' => 'required|date',
                'time' => 'required|date_format:H:i',
                'max_bookings' => 'required|integer|min:1',
            ]);

            $exists = $this->bookingSlot->where('date', $validated['date'])
                ->where('time', $validated['time'])
                ->exists();

            if ($exists) {
                return response()->json(['message' => 'Slot pada jam tersebut sudah ada!'], 422);
            }

            $this->bookingSlot->create([
                'date' => $validated['date'],
                'time' => $validated['time'],
                'max_bookings' => $validated['max_bookings'],
                'current_bookings' => 0,
            ]);

            return response()->json(['message' => 'Slot berhasil ditambahkan!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menambahkan slot: ' . $e->getMessage()], 500);
        }
    }

    public function generate(Request $request)
    {
        try {
            $request->validate(['date' => 'required|date']);

            if ($this->bookingSlot->whereDate('date', $request->date)->exists()) {
                return response()->json(['message' => 'Slot di tanggal ini sudah tersedia.'], 422);
            }

            $this->bookingSlotService->generateSlotsForDate($request->date);

            return response()->json(['message' => 'Slot berhasil digenerate.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal generate slot: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $slot = $this->bookingSlot->findOrFail($id);

            $request->validate([
                'time' => 'required',
                'max_bookings' => 'required|integer|min:1',
            ]);

            $slot->time = $request->time;
            $slot->max_bookings = $request->max_bookings;
            $slot->save();

            return response()->json(['message' => 'Slot berhasil diperbarui.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal memperbarui slot: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $slot = $this->bookingSlot->findOrFail($id);

            if ($slot->current_bookings > 0) {
                return response()->json(['message' => 'Slot ini sudah memiliki booking dan tidak bisa dihapus.'], 400);
            }

            $slot->delete();

            return response()->json(['message' => 'Slot berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menghapus slot: ' . $e->getMessage()], 500);
        }
    }
}
