@extends('panel.layouts.app')

@section('title', 'Pengajuan Pelatihan')

@section('content')
<div class="container px-6 mx-auto py-6">
    <h1 class="text-2xl font-bold mb-6">Pengajuan Jadwal Pelatihan</h1>
    <div class="space-y-4">
        @forelse($bookings as $booking)
            <div class="bg-white border rounded-xl p-5">
                <div class="flex flex-wrap justify-between gap-3">
                    <div>
                        <h2 class="font-semibold">{{ $booking->program->program }}</h2>
                        <p class="text-sm text-gray-600">{{ $booking->student->name }} · {{ $booking->training_days }} hari · Rp{{ number_format($booking->total_amount, 0, ',', '.') }}</p>
                        <p class="text-sm text-gray-500 mt-1">{{ $booking->dates->pluck('training_date')->map(fn ($date) => $date->format('d M Y'))->join(', ') }}</p>
                    </div>
                    <span class="text-sm font-semibold">
                        {{ $booking->locked_at ? 'Terkunci / Lunas' : $booking->schedule_status }}
                    </span>
                </div>
                @if($booking->schedule_status === 'pending_admin')
                    <div class="flex gap-2 mt-4">
                        <form method="POST" action="{{ route('admin.training-bookings.approve', $booking) }}">
                            @csrf
                            <button class="rounded-lg bg-green-600 text-white px-4 py-2 text-sm">Setujui</button>
                        </form>
                        <form method="POST" action="{{ route('admin.training-bookings.reject', $booking) }}" class="flex gap-2">
                            @csrf
                            <input name="admin_notes" required placeholder="Alasan penolakan" class="rounded-lg border-gray-300 text-sm">
                            <button class="rounded-lg bg-red-600 text-white px-4 py-2 text-sm">Tolak</button>
                        </form>
                    </div>
                @endif
            </div>
        @empty
            <p class="text-gray-500">Belum ada pengajuan jadwal.</p>
        @endforelse
    </div>
    <div class="mt-6">{{ $bookings->links() }}</div>
</div>
@endsection
