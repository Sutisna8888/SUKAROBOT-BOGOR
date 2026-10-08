@php
    $role = request()->is('admin*') ? 'admin' : 'instructor';
    $primaryColor = $role === 'admin' ? '#F97316' : '#3B82F6';
@endphp

<script>
    window.SwalConfig = {
        role: '{{ $role }}',
        primaryColor: '{{ $primaryColor }}',

        success: function (title, text = '') {
            return Swal.fire({
                icon: 'success',
                title: title,
                text: text,
                confirmButtonColor: this.primaryColor
            });
        },

        error: function (title, text = '') {
            return Swal.fire({
                icon: 'error',
                title: title,
                text: text,
                confirmButtonColor: this.primaryColor
            });
        },

        confirmDelete: function (itemName = 'data ini') {
            return Swal.fire({
                title: 'Konfirmasi Hapus',
                text: `Apakah Anda yakin ingin menghapus ${itemName}? Tindakan ini tidak dapat dibatalkan.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            });
        },

        confirm: function (title, text, confirmText = 'Ya, Lanjutkan') {
            return Swal.fire({
                title: title,
                text: text,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: this.primaryColor,
                cancelButtonColor: '#6B7280',
                confirmButtonText: confirmText,
                cancelButtonText: 'Batal'
            });
        },

        validationError: function (errors) {
            let errorText = '';
            if (Array.isArray(errors)) {
                errorText = errors.join('\n• ');
                errorText = '• ' + errorText;
            } else if (typeof errors === 'string') {
                errorText = errors;
            }

            return Swal.fire({
                title: 'Validasi Gagal',
                text: `Mohon periksa kembali data yang Anda masukkan:\n\n${errorText}`,
                icon: 'error',
                confirmButtonColor: this.primaryColor,
                confirmButtonText: 'Perbaiki'
            });
        }
    };

    @php
        $isProgramForm = request()->is('*/programs/create') || request()->is('*/programs/*/edit');
        $hasFlash = session('success') || session('error') || $errors->any() || session('info');
    @endphp

    @unless($isProgramForm)
    @if($hasFlash)
    (function() {
        var flashId = '{{ md5(session()->getId() . microtime()) }}';

        function showFlashAlerts() {
            if (sessionStorage.getItem('_swal_shown_' + flashId)) return;
            sessionStorage.setItem('_swal_shown_' + flashId, '1');

            var keys = [];
            for (var i = 0; i < sessionStorage.length; i++) {
                var key = sessionStorage.key(i);
                if (key && key.startsWith('_swal_shown_')) keys.push(key);
            }
            if (keys.length > 10) {
                keys.slice(0, keys.length - 10).forEach(function(k) { sessionStorage.removeItem(k); });
            }

            @if(session('success'))
                SwalConfig.success('Berhasil!', '{{ session('success') }}');
            @endif

            @if(session('error'))
                SwalConfig.error('Gagal!', '{{ session('error') }}');
            @endif

            @if(session('info'))
                Swal.fire({
                    icon: 'info',
                    title: 'Info',
                    text: '{{ session('info') }}',
                    confirmButtonColor: window.SwalConfig.primaryColor
                });
            @endif

            @if($errors->any())
                var errorMessages = @json($errors->all());
                SwalConfig.validationError(errorMessages);
            @endif
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', showFlashAlerts);
        } else {
            showFlashAlerts();
        }

        window.addEventListener('pageshow', function(e) {
            if (e.persisted) {
                if (typeof Swal !== 'undefined' && Swal.isVisible()) {
                    Swal.close();
                }
            }
        });
    })();
    @endif
    @endunless

    function confirmDeleteForm(form, itemName = 'data ini') {
        SwalConfig.confirmDelete(itemName).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
        return false;
    }
</script>