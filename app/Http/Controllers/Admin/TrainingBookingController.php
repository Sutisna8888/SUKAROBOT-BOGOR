<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrainingBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TrainingBookingController extends Controller
{
    public function index()
    {
        $bookings = TrainingBooking::with(['student', 'program', 'dates'])
            ->latest()
            ->paginate(20);

        return view('admin.training-bookings.index', compact('bookings'));
    }

    public function approve(Request $request, TrainingBooking $trainingBooking)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:2000',
        ]);

        DB::transaction(function () use ($request, $trainingBooking) {
            $trainingBooking->load('dates');

            abort_if($trainingBooking->schedule_status !== 'pending_admin', 422, 'Pengajuan ini sudah diproses.');
            abort_if($trainingBooking->locked_at, 422, 'Jadwal ini sudah dikunci oleh pembayaran.');

            $hasConflict = TrainingBooking::where('id', '!=', $trainingBooking->id)
                ->where(function ($query) {
                    $query->whereIn('schedule_status', ['approved'])
                        ->orWhereNotNull('locked_at');
                })
                ->whereHas('dates', function ($query) use ($trainingBooking) {
                    $query->whereIn('training_date', $trainingBooking->dates->pluck('training_date'));
                })
                ->exists();

            abort_if($hasConflict, 422, 'Sebagian tanggal sudah digunakan oleh pemesanan lain.');

            $trainingBooking->update([
                'schedule_status' => 'approved',
                'approved_by' => Auth::guard('admin')->id(),
                'approved_at' => now(),
                'admin_notes' => $request->input('admin_notes'),
            ]);
        });

        return back()->with('success', 'Jadwal pelatihan disetujui. Peserta dapat melanjutkan pembayaran.');
    }

    public function reject(Request $request, TrainingBooking $trainingBooking)
    {
        abort_if($trainingBooking->schedule_status !== 'pending_admin', 422, 'Pengajuan ini sudah diproses.');

        $validated = $request->validate([
            'admin_notes' => 'required|string|max:2000',
        ]);

        $trainingBooking->update([
            'schedule_status' => 'rejected',
            'admin_notes' => $validated['admin_notes'],
        ]);

        return back()->with('success', 'Pengajuan jadwal ditolak.');
    }
}
