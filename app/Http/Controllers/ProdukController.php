<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\LogStok;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    // Menampilkan daftar produk
    public function index()
    {
        $title = 'Produk'; 
        $subtitle = 'Index';
        $produks = Produk::all(); // Ambil semua data produk
        return view('admin.produk.index', compact('title', 'subtitle', 'produks'));
    }

    // Menampilkan form untuk tambah produk baru
    public function create()
    {
        $title = 'Produk'; 
        $subtitle = 'Create';
        return view('admin.produk.create', compact('title', 'subtitle'));
    }

    // Proses simpan produk baru
    public function store(Request $request)
    {
        $validate = $request->validate([
            'NamaProduk' => 'required',
            'Harga' => 'required|numeric',
            'Stok' => 'required|numeric',
        ]);

        $simpan = Produk::create($validate);

        if ($simpan) {
            return redirect()->route('produk.index')->with('success', 'Produk berhasil disimpan!');
        } else {
            return redirect()->route('produk.index')->with('error', 'Produk gagal disimpan.');
        }
    }

    // Menampilkan form edit produk
    public function edit($id)
    {
        $produk = Produk::findOrFail($id);

        return view('admin.produk.edit', [
            'title' => 'Edit Produk',
            'subtitle' => 'Form Edit Produk',
            'produk' => $produk,
        ]);
    }

    // Proses update produk
    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'NamaProduk' => 'required',
            'Harga' => 'required|numeric',
            'Stok' => 'required|numeric',
        ]);

        $produk = Produk::findOrFail($id);
        $produk->update($validate);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui!');
    }

    // Hapus produk
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $delete = $produk->delete();

        if ($delete) {
            return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
        } else {
            return redirect()->route('produk.index')->with('error', 'Produk gagal dihapus.');
        }
    }

    // Menampilkan form tambah stok
    public function formTambahStok($id)
    {
        $produk = Produk::findOrFail($id); 
        return view('admin.produk.tambahStok', compact('produk'));
    }

    // Proses tambah stok
    public function prosesTambahStok(Request $request, $id)
    {
        $request->validate([
            'jumlah_stok' => 'required|integer|min:1',
        ]);

        $produk = Produk::findOrFail($id);
        $stokAwal = $produk->Stok;
        $produk->Stok += $request->jumlah_stok; 
        $produk->save();

        LogStok::create([
            'produk_id' => $produk->id,
            'stok_awal' => $stokAwal,
            'stok_akhir' => $produk->Stok,
            'perubahan' => $request->jumlah_stok,
            'keterangan' => 'Penambahan stok manual',
        ]);

        return redirect()->route('produk.index')->with('success', 'Stok berhasil ditambahkan!');
    }

    // Proses pengurangan stok
    public function reduceStock($id, $quantity)
    {
        $produk = Produk::findOrFail($id);

        if ($produk->Stok >= $quantity) {
            $stokAwal = $produk->Stok;
            $produk->Stok -= $quantity;
            $produk->save();

            LogStok::create([
                'produk_id' => $produk->id,
                'stok_awal' => $stokAwal,
                'stok_akhir' => $produk->Stok,
                'perubahan' => -$quantity, 
                'keterangan' => 'Pengurangan stok karena transaksi',
            ]);

            return redirect()->route('produk.index')->with('success', 'Stok berhasil dikurangi!');
        } else {
            return redirect()->route('produk.index')->with('error', 'Stok tidak cukup.');
        }
    }
}
