<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Konfigurasi Toast untuk notifikasi kecil
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3500,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        // Menampilkan notifikasi dari session flash Laravel
        @if (session('success'))
            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}'
            });
        @endif

        @if (session('error'))
            Toast.fire({
                icon: 'error',
                title: '{{ session('error') }}'
            });
        @endif

        // Menangani event dari komponen Livewire
        // Pastikan listener ini ada di luar 'livewire:initialized' agar bisa menangkap event dari awal
        if (typeof Livewire !== 'undefined') {
            // Notifikasi sukses/error dari Livewire
            Livewire.on('dispatch-notification', event => {
                Toast.fire({
                    icon: event.type, // 'success' atau 'error'
                    title: event.message
                });
            });

            // Konfirmasi penghapusan dari Livewire
            Livewire.on('show-delete-confirmation', event => {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Anda tidak akan dapat mengembalikan tindakan ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Panggil metode delete di komponen Livewire
                        Livewire.dispatch('delete-confirmed', { id: event.id });
                    }
                });
            });
        }
    });

    // Fungsi untuk konfirmasi (bisa untuk logout atau form biasa)
    function confirmAction(event, formId, title = 'Apakah Anda yakin?', text = 'Lanjutkan tindakan ini?') {
        event.preventDefault();
        Swal.fire({
            title: title,
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Lanjutkan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(formId).submit();
            }
        });
    }
</script>