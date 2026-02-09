<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
(function(){

    // SUCCESS
    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: {!! json_encode(session('success')) !!},
        timer: 3000,
        showConfirmButton: false
    });
    @endif

    // ERROR
    @if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: {!! json_encode(session('error')) !!}
    });
    @endif

    // VALIDATION
    @if($errors->any())
    Swal.fire({
        icon: 'error',
        title: 'Terjadi kesalahan',
        html: `{!! implode('<br>', $errors->all()) !!}`
    });
    @endif


    document.addEventListener('DOMContentLoaded', function(){

        // DELETE CONFIRM
        document.querySelectorAll('form.confirm-delete').forEach(function(form){

            form.addEventListener('submit', function(e){
                e.preventDefault();

                let msg = form.dataset.confirmMessage || 'Anda yakin ingin menghapus data ini?';

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


        // SUBMIT CONFIRM (CREATE & UPDATE)
        document.querySelectorAll('form.confirm-submit').forEach(function(form){

            form.addEventListener('submit', function(e){
                e.preventDefault();

                let msg = form.dataset.confirmMessage || 'Yakin ingin menyimpan data ini?';

                Swal.fire({
                    title: msg,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, simpan',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then(function(res){

                    if(res.isConfirmed){
                        form.submit();
                    }

                });
            });

        });

    });

})();
</script>
