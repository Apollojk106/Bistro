<div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Sucesso!',
            text: '{{ session("success") }}',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Erro!',
            text: '{{ session("error") }}',
            confirmButtonColor: '#d33',
            confirmButtonText: 'Tentar novamente'
        });
    </script>
    @endif

    @if ($errors->any())
    <script>
        let errorMessage = "{{ implode('\n', $errors->all()) }}";

        Swal.fire({
            icon: 'error',
            title: 'Erro de Validação!',
            text: errorMessage,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Corrigir'
        });
    </script>
    @endif
</div>