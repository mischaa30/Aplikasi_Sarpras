@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Berhasil!</strong> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Gagal!</strong> {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Ada kesalahan:</strong>
    <ul class="mb-0">
        @foreach($errors->all() as $err)
        <li>{{ $err }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<!-- SweetAlert2 and helper scripts for nicer messages and confirmation dialogs -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
(function(){
    // Show SweetAlert for session messages (JS-first, fallback is the Bootstrap alerts above)
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: {!! json_encode(session('success')) !!},
            timer: 3500,
            showConfirmButton: false
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: {!! json_encode(session('error')) !!}
        });
    @endif

    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Terjadi kesalahan',
            html: `{!! implode('<br>', $errors->all()) !!}`
        });
    @endif

    // Handle delete confirmations on forms with class "confirm-delete"
    document.addEventListener('DOMContentLoaded', function(){
        document.querySelectorAll('form.confirm-delete').forEach(function(form){
            form.addEventListener('submit', function(e){
                e.preventDefault();
                var msg = form.dataset.confirmMessage || 'Anda yakin ingin menghapus data ini?';

                Swal.fire({
                    title: msg,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then(function(res){
                    if(res.isConfirmed){
                        form.submit();
                    }
                });
            });
        });

        // Auto-dismiss bootstrap alerts after 4s
        setTimeout(function(){
            document.querySelectorAll('.alert-dismissible').forEach(function(a){
                try{
                    var bsAlert = new bootstrap.Alert(a);
                    a.classList.remove('show');
                    a.addEventListener('transitionend', function(){ a.remove(); });
                }catch(e){/* ignore */}
            });
        }, 4000);
    });
})();
</script>