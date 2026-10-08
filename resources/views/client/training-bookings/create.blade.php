@extends('client.main')

@section('body')
<main class="w-full max-w-5xl mx-auto px-4 sm:px-6 pt-24 pb-20 min-w-0">
    <div class="w-full min-w-0 max-w-full bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-700 to-blue-500 px-4 sm:px-6 py-6 sm:py-7 text-white">
            <p class="text-sm font-semibold uppercase tracking-wide text-blue-100">Program Pelatihan</p>
            <h1 class="mt-1 text-xl sm:text-2xl font-bold break-words">{{ $program->program }}</h1>
            <p class="mt-2 text-xs sm:text-sm text-blue-100 break-words">
                Periode tersedia {{ $periodStart->format('d M Y') }} - {{ $periodEnd->format('d M Y') }}
            </p>
        </div>

        <div class="p-4 sm:p-6 min-w-0 max-w-full">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 sm:gap-3 rounded-xl bg-orange-50 border border-orange-100 px-3 sm:px-4 py-3">
                <p class="text-sm leading-relaxed text-orange-800">
                    Pilih 1 sampai 7 tanggal. Tanggal boleh terpisah.
                </p>
                <p class="text-sm text-orange-700 font-bold whitespace-nowrap self-start sm:self-auto">
                    Rp{{ number_format($dailyPrice, 0, ',', '.') }} / hari
                </p>
            </div>

        @if(session('success'))
            <div class="mt-4 rounded-lg bg-green-50 text-green-700 px-4 py-3">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="mt-4 rounded-lg bg-red-50 text-red-700 px-4 py-3">{{ $errors->first() }}</div>
        @endif

        @php($bookingTransaction = $booking?->transactions?->firstWhere('status', 'paid'))
        @if($booking && $booking->schedule_status === 'approved')
            <div class="mt-5 rounded-lg bg-blue-50 text-blue-800 px-4 py-3">
                Jadwal disetujui admin. Total pembayaran:
                <strong>Rp{{ number_format($booking->total_amount, 0, ',', '.') }}</strong>.
            </div>
            @if($bookingTransaction)
                <div class="mt-4 rounded-lg bg-green-50 text-green-700 px-4 py-3">
                    Pembayaran berhasil. Jadwal pelatihan sudah dikunci.
                </div>
            @else
                <button type="button" id="training-pay-button" class="mt-4 w-full rounded-lg bg-orange-500 text-white py-3 font-semibold hover:bg-orange-600">
                    Bayar Jadwal Pelatihan
                </button>
            @endif
        @elseif($booking && $booking->schedule_status === 'pending_admin')
            <div class="mt-5 rounded-lg bg-yellow-50 text-yellow-800 px-4 py-3">
                Pengajuan sedang menunggu konfirmasi admin.
            </div>
        @endif

        <form method="POST" action="{{ route('client.training-bookings.store', $program->slug) }}" class="mt-6 w-full min-w-0 max-w-full">
            @csrf
            @php($selectedDates = collect(old('training_dates', [])))
            <div class="flex items-center justify-between gap-3 mb-3">
                <label class="block text-sm font-semibold text-gray-700">Tanggal tersedia</label>
                <span id="selected-date-count" class="text-xs font-semibold text-gray-500">0 tanggal dipilih</span>
            </div>
            <div class="mb-4 rounded-xl border border-green-200 bg-green-50 px-3 sm:px-4 py-3 text-sm leading-relaxed text-green-800">
                <strong>Konfirmasi ketersediaan tanggal:</strong>
                selalu hubungi admin terlebih dahulu untuk memastikan tanggal yang tersedia sebelum mengajukan jadwal.
            </div>
            <div id="training-dates" class="grid w-full min-w-0 max-w-full grid-cols-2 gap-2 sm:grid-cols-4 sm:gap-3 lg:grid-cols-7">
                    @foreach($availableDates as $date)
                        @php($dateValue = $date->toDateString())
                        <label class="training-date-option min-w-0 cursor-pointer">
                            <input
                                type="checkbox"
                                name="training_dates[]"
                                value="{{ $dateValue }}"
                                class="peer sr-only"
                                {{ $selectedDates->contains($dateValue) ? 'checked' : '' }}
                            >
                            <span class="flex w-full min-w-0 flex-col items-center rounded-xl border border-gray-200 bg-gray-50 px-2 py-3 text-center transition peer-checked:border-blue-600 peer-checked:bg-blue-50 peer-checked:text-blue-700 hover:border-blue-300">
                                <span class="text-xs font-medium uppercase text-gray-500 peer-checked:text-blue-600">{{ $date->format('D') }}</span>
                                <span class="mt-1 text-xl font-bold">{{ $date->format('d') }}</span>
                                <span class="text-xs">{{ $date->format('M Y') }}</span>
                            </span>
                        </label>
                    @endforeach
            </div>
            <p class="mt-3 text-sm text-gray-500">Pilih tanggal yang diinginkan.</p>
            <button type="submit" class="mt-6 w-full rounded-lg bg-orange-500 text-white py-3 font-semibold hover:bg-orange-600">Ajukan Jadwal ke Admin</button>
        </form>

        <a href="https://wa.me/6285795899901?text={{ urlencode('Halo Admin, saya ingin menanyakan ketersediaan jadwal Program Pelatihan sebelum lomba tanggal ' . optional($program->competition_date)->format('d-m-Y') . '. Saya ingin mengusulkan jadwal pelatihan.') }}"
           target="_blank"
           rel="noopener"
           class="mt-3 block w-full rounded-lg border border-green-600 text-green-700 text-center py-3 font-semibold hover:bg-green-50">
            Hubungi Admin untuk Cek Jadwal
        </a>
    </div>
</div>
</main>

@if($booking && $booking->schedule_status === 'approved' && !$bookingTransaction)
<script src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
document.getElementById('training-pay-button').addEventListener('click', function () {
    const button = this;
    button.disabled = true;
    button.textContent = 'Memproses...';
    fetch('{{ route('client.training-bookings.payment.create', $booking) }}', {
        method: 'POST',
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json'}
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) throw new Error(data.error);
        snap.pay(data.snap_token, {
            onSuccess: result => window.location.href = '{{ route('client.payment.finish') }}?order_id=' + result.order_id + '&status=success',
            onPending: result => window.location.href = '{{ route('client.payment.finish') }}?order_id=' + result.order_id + '&status=pending',
            onError: result => window.location.href = '{{ route('client.payment.finish') }}?order_id=' + result.order_id + '&status=error',
            onClose: () => { button.disabled = false; button.textContent = 'Bayar Jadwal Pelatihan'; }
        });
    })
    .catch(error => {
        alert(error.message);
        button.disabled = false;
        button.textContent = 'Bayar Jadwal Pelatihan';
    });
});
</script>
@endif

<script>
const trainingDateInputs = document.querySelectorAll('input[name="training_dates[]"]');
const selectedDateCount = document.getElementById('selected-date-count');

function updateSelectedDateCount() {
    const selectedCount = document.querySelectorAll('input[name="training_dates[]"]:checked').length;
    selectedDateCount.textContent = selectedCount + ' tanggal dipilih';
}

trainingDateInputs.forEach(input => input.addEventListener('change', updateSelectedDateCount));
updateSelectedDateCount();
</script>
@endsection
