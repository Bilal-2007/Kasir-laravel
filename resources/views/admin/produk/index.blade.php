@extends('admin.template.master')
@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('') }}plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('') }}plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('') }}plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endsection

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">{{ $title }}</h1>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $title }}</h3>
                    <a href="{{ route('produk.create') }}" class="btn btn-sm btn-warning float-right">Tambah</a>
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($produks as $produk)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $produk->NamaProduk }}</td>
                                <td>{{ rupiah($produk->Harga) }}</td>
                                <td>{{ $produk->Stok }}</td>
                                <td>
                                    <form id="form-delete-produk-{{ $produk->id }}" action="{{ route('produk.destroy', $produk->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{ route('produk.edit', $produk->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="{{ $produk->id }}">Delete</button>
                                        <a href="{{ route('produk.formTambahStok', $produk->id) }}" class="btn btn-sm btn-success">Tambah Stok</a>
                                        @if(session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                        @endif


                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('js')
<script>
    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        const formId = $(this).data('id');
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Data tidak akan bisa kembali!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus data ini!'
        }).then((result) => {
            if (result.isConfirmed) {
                $(`#form-delete-produk-${formId}`).submit();
            }
        });
    });
</script>
@endsection