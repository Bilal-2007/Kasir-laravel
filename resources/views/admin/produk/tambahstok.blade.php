@extends('admin.template.master')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <h1>Tambah Stok untuk {{ $produk->NamaProduk }}</h1>
    </div>

    <div class="content">
        <div class="container-fluid">
            <form action="{{ route('produk.prosesTambahStok', $produk->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="jumlah_stok">Jumlah Stok</label>
                    <input type="number" name="jumlah_stok" id="jumlah_stok" class="form-control" required min="1">
                </div>
                <button type="submit" class="btn btn-success">Tambah Stok</button>
                <a href="{{ route('produk.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
