<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\TrainingBooking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TrainingBookingController extends Controller
{
    private const DAILY_PRICE = 100000;

    public function create(string $programSlug)
    {
        $program = Program::where('slug', $programSlug)
            ->where('status', 'published')
            ->firstOrFail();

        abort_unless(strtolower((string) $program->category) === 'pelatihan', 404);
        abort_unless($program->competition_date, 422, 'Tanggal lomba belum diatur.');

        $competitionDate = Carbon::parse($program->competition_date)->startOfDay();
        $periodStart = $competitionDate->copy()->subDays(13);
        $periodEnd = $competitionDate->copy()->subDays(7);
        $booking = TrainingBooking::with(['dates', 'transactions'])
            ->where('student_id', Auth::id())
            ->where('program_id', $program->id)
            ->latest()
            ->first();
        $availableDates = collect();
        for ($date = $periodStart->copy(); $date->lte($periodEnd); $date->addDay()) {
            $availableDates->push($date->copy());
        }

        return view('client.training-bookings.create', [
            'program' => $program,
            'periodStart' => $periodStart,
            'periodEnd' => $periodEnd,
            'availableDates' => $availableDates,
            'dailyPrice' => self::DAILY_PRICE,
            'booking' => $booking,
        ]);
    }

    public function store(Request $request, string $programSlug)
    {
        $program = Program::where('slug', $programSlug)
            ->where('status', 'published')
            ->firstOrFail();

        abort_unless(strtolower((string) $program->category) === 'pelatihan', 404);
        abort_unless($program->competition_date, 422, 'Tanggal lomba belum diatur.');

        $validated = $request->validate([
            'training_dates' => 'required|array|min:1|max:7',
            'training_dates.*' => 'required|date|distinct',
        ]);

        $competitionDate = Carbon::parse($program->competition_date)->startOfDay();
        $periodStart = $competitionDate->copy()->subDays(13);
        $periodEnd = $competitionDate->copy()->subDays(7);
        $dates = collect($validated['training_dates'])
            ->map(fn (string $date) => Carbon::parse($date)->startOfDay())
            ->sort()
            ->values();

        if ($dates->contains(fn (Carbon $date) => $date->lt($periodStart) || $date->gt($periodEnd))) {
            return back()->withInput()->withErrors([
                'training_dates' => 'Semua tanggal harus berada dalam periode pelatihan yang tersedia.',
            ]);
        }

        if ($periodEnd->lt(Carbon::today())) {
            return back()->withInput()->withErrors([
                'training_dates' => 'Periode pelatihan untuk lomba ini sudah lewat.',
            ]);
        }

        $studentId = Auth::id();
        $hasActiveBooking = TrainingBooking::where('student_id', $studentId)
            ->where('program_id', $program->id)
            ->whereIn('schedule_status', ['pending_admin', 'approved'])
            ->exists();

        if ($hasActiveBooking) {
            return back()->withInput()->withErrors([
                'training_dates' => 'Anda sudah memiliki pengajuan pelatihan aktif untuk program ini.',
            ]);
        }

        $trainingBooking = DB::transaction(function () use ($studentId, $program, $dates) {
            $booking = TrainingBooking::create([
                'student_id' => $studentId,
                'program_id' => $program->id,
                'schedule_status' => 'pending_admin',
                'training_days' => $dates->count(),
                'daily_price' => self::DAILY_PRICE,
                'total_amount' => $dates->count() * self::DAILY_PRICE,
            ]);

            $booking->dates()->createMany(
                $dates->map(fn (Carbon $date) => ['training_date' => $date->toDateString()])->all()
            );

            return $booking;
        });

        return redirect()
            ->route('client.training-bookings.create', $program->slug)
            ->with('success', 'Pengajuan jadwal berhasil dikirim. Admin akan mengonfirmasi ketersediaan tanggal.');
    }
}
