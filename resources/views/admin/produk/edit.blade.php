@extends('admin.template.master')
@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('') }}plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('') }}plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('') }}plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $title }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">{{ $title }}</a></li>
                        <li class="breadcrumb-item active">{{ $subtitle }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $title }}</h3>
                    <a href="{{ route('produk.create') }}" class="btn btn-sm btn-warning float-right">Kembali</a>
                    @if ($errors->any())
                    @foreach ($errors->all() as $error)
                    <div class="alert alert-danger" role="alert">
                        {{ $error }}
                    </div>
                    @endforeach
                    @endif
                    <div id="error-container" style=" display:none">
                        <div class="alert alert-danger">
                            <p id="error-message"></p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form id="form-update-produk" method="post">
                        
                        <label for="">Nama Produk</label>
                        <input type="text" name="NamaProduk" value="{{ $produk->NamaProduk }}" class="form-control" required>
                        <label for="">Harga</label>
                        <input type="number" name="Harga" value="{{ $produk->Harga }}" class="form-control" required>
                        <label for="">Stok</label>
                        <input type="number" name="Stok" value="{{ $produk->Stok }}" class="form-control" required>
                        <button class="btn btn-warning mt-3" type="submit">Update</button>
                    </form>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('js')
<!-- DataTables  & Plugins -->
<script src="{{ asset('') }}plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('') }}plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('') }}plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('') }}plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{ asset('') }}plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('') }}plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{ asset('') }}plugins/jszip/jszip.min.js"></script>
<script src="{{ asset('') }}plugins/pdfmake/pdfmake.min.js"></script>
<script src="{{ asset('') }}plugins/pdfmake/vfs_fonts.js"></script>
<script src="{{ asset('') }}plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{ asset('') }}plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{ asset('') }}plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>

<script>
   $(document).ready(function() {
    $("#form-update-produk").submit(function(e) {
        e.preventDefault();

        let dataForm = $(this).serialize() + "&_token={{ csrf_token() }}" + "&_method=PUT";
        $.ajax({
            type: "POST", 
            url: "{{ route('produk.update', $produk->id) }}",
            data: dataForm,
            dataType: "json",
            success: function(data) {
                Swal.fire({
                    icon: 'success',
    <!-- Content Header (Page header) -->
                    title: "Success",
                    text: data.message,
                    confirmButtonText: 'ok'
                });
                $('input[name="NamaProduk"]').val('');
                $('input[name="Harga"]').val('');
                $('input[name="Stok"]').val('');
            },
            error: function(data) {
                let errorMessage = "Terjadi kesalahan.";
                if (data.responseJSON && data.responseJSON.message) {
                    errorMessage = data.responseJSON.message;
                }
                console.log(errorMessage);
                Swal.fire({
                    icon: 'error',
                    title: "Error",
                    text: errorMessage,
                    confirmButtonText: 'ok'
                });
            }
        });
    });
});

</script>
@endsection
