@extends('client.layouts.dashboard')

@section('title', 'Notifikasi')

@section('dashboard-content')
    <div class="flex items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Notifikasi</h1>
            <p class="mt-1 text-sm text-gray-500">Informasi terbaru untuk akun Anda.</p>
        </div>
        @if($unreadNotificationCount > 0)
            <form method="POST" action="{{ route('client.notifications.read-all') }}">
                @csrf
                <button type="submit" class="text-sm font-semibold text-blue-600 hover:text-blue-800">
                    Tandai semua dibaca
                </button>
            </form>
        @endif
    </div>

    <div class="space-y-3">
        @forelse($notifications as $notification)
            <div class="rounded-xl border {{ $notification->is_read ? 'border-gray-100 bg-white' : 'border-blue-100 bg-blue-50/60' }} p-4">
                <div class="flex items-start justify-between gap-4">
                    <div class="min-w-0">
                        <div class="flex items-center gap-2">
                            <h2 class="font-semibold text-gray-900">{{ $notification->title }}</h2>
                            @if(!$notification->is_read)
                                <span class="inline-flex items-center gap-1 rounded-full bg-blue-100 px-2 py-0.5 text-xs font-semibold text-blue-700">
                                    <span class="h-1.5 w-1.5 rounded-full bg-blue-600"></span>
                                    Belum dibaca
                                </span>
                            @endif
                        </div>
                        <p class="mt-1 text-sm text-gray-600 whitespace-pre-line">{{ $notification->message }}</p>
                        <p class="mt-2 text-xs text-gray-400">{{ \Carbon\Carbon::parse($notification->created_at)->translatedFormat('d F Y, H:i') }}</p>
                    </div>
                    <div class="flex shrink-0 items-center gap-3">
                        @if(!$notification->is_read)
                            <form method="POST" action="{{ route('client.notifications.read', $notification->id) }}">
                                @csrf
                                <button type="submit" class="whitespace-nowrap text-sm font-semibold text-blue-600 hover:text-blue-800">
                                    Tandai dibaca
                                </button>
                            </form>
                        @endif
                        <form method="POST" action="{{ route('client.notifications.destroy', $notification->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-notification-btn text-sm font-semibold text-red-500 hover:text-red-700">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="rounded-xl border border-dashed border-gray-200 p-10 text-center text-gray-500">
                Belum ada notifikasi.
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $notifications->links() }}
    </div>
@endsection

@section('dashboard-js')
<script>
    document.querySelectorAll('.delete-notification-btn').forEach((button) => {
        button.addEventListener('click', (event) => {
            event.preventDefault();
            const form = button.closest('form');

            Swal.fire({
                title: 'Hapus notifikasi?',
                text: 'Notifikasi yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    @if(session('success'))
        Swal.fire({
            title: 'Berhasil!',
            text: @json(session('success')),
            icon: 'success',
            confirmButtonColor: '#3b82f6'
        });
    @endif
</script>
@endsection
