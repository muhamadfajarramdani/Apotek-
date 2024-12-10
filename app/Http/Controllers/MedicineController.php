<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;
use App\Exports\ObatExport;
use Maatwebsite\Excel\Facades\Excel;

class MedicineController extends Controller
{
    /**
     * R: read, menampilkan banyak data/halaman awal fitur
     */
        public function exportExcelObat()
        {
            return Excel::download(new ObatExport, 'rekap-data-obat.xlsx');
        }
    public function index(Request $request)
    {
        // ALL() : mengambil semua data
        // orderBy() : mengurutkan
        // ASC : A-Z, 0-9
        // DEC : z-a, 9-0
        // kalau ambil smua daya tp ada proses filter sebelumnya, all nya diganti jadi get
        // simplePaginate() : memisahkan data dengan pagination, angka 5 menunjukan jumlah data per halaman
        // $medicine = Medicine::orderBy('name', 'ASC')->simplePaginate(6);
        $orderStock = $request->short_stock ? 'stock' : 'name';
        $medicine = Medicine::where('name', 'LIKE', '%' . $request->search_obat . '%')->orderBy($orderStock, 'ASC')->simplePaginate(5)->appends($request->all());
        // compact () : mengirim data ke view (isinya sama dengan $)
        return view('medicine.index', compact('medicine'));
    }

    /**
     * C: create, menampilkan form untuk menambahkan data
     */
    public function create()
    {
        //
        return view('medicine.create');
    }

    /**
     * C: create, menambahkan data ke db/eksekusi formulir
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'type' => 'required|min:3',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
        ], [
            'name.required' => 'Nama obat harus diisi !',
            'type.required' => 'Jenis obat harus diisi !',
            'price.required' => 'Harga obat harus diisi !',
            'stock.required' => 'Stok obat harus diisi !',
            'type.min' => 'Jenis obat minimal 3 karakter',
            'name.max' => 'Nama obat maksimal 10 karakter',
            'price.numeric' => 'Harga obat harus berupa angka',
        ]);

        Medicine::create([
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price,
            'stock' => $request->stock,

        ]);

        return redirect()->route('obat.data')->with('success', 'Berhasil menambahkan data obat!');
    }

    /**
     *
     */
    // menampilkan satu data
    public function show(string $id)
    {
        //
    }

    /**
     * R: read, menampilkan data spesifik (data cuman 1)
     */

    // atau $medicine = Medicine::where ('id', $id)->first();

    public function edit($id, Request $request)
{
    // Ambil data obat berdasarkan ID
    $medicine = Medicine::findOrFail($id);

    // Jika ada request untuk mengurutkan stok
    if ($request->has('sort') && $request->sort == 'stock') {
        // Mengurutkan stok dari terbesar ke terkecil
        $medicines = Medicine::orderBy('stock', 'desc')->get();
    } else {
        // Default behavior jika tidak ada permintaan untuk sorting
        $medicines = Medicine::orderBy('name', 'ASC')->get();
    }

    // Kembalikan view dengan data obat yang sudah diurutkan atau tidak
    return view('medicine.edit', compact('medicine', 'medicines'));
}




    /**
     * U: update, mengupdate data ke db/eksekusi formulir edit
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'price' => 'required',
        ]);

        Medicine::where('id', $id)->update([
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price,
        ]);
        return redirect()->route('obat.data')->with('success', 'Berhasil mengupdate data obat!');
    }

    public function updateStock(Request $request, $id)
    {
        // untuk modal tanpa ajax, tdk support validasi, jd gunakan isset untul pengecekan required nya
        if (isset($request->stock) == FALSE) {
            $dataSebelumnya = Medicine::where('id', $id)->first();
            // kembali dengan pesam, id sblmnya =, dan stock sblmnya (stock awal)
            return redirect()->back()->with([
                'failed' => 'stock tidak boleh kosong',
                'id' => $id,
                'stock' => $dataSebelumnya->stock,
            ]);
        }
        // jika tdk kosong, langsung update stock
        Medicine::where('id', $id)->update([
            'stock' => $request->stock,
        ]);

        return redirect()->back()->with('success', 'Berhasil mengupdate stok obat!');
    }

    /**
     * D: delete, menghapus data dari db
     */
    public function destroy($id)
    {
        $deleteData = Medicine::where('id', $id)->delete();

        if ($deleteData) {
            return redirect()->back()->with('success', 'Berhasil menghapus data obat!');
        } else {
            return redirect()->back()->with('failed', 'Gagal menghapus data obat!');
        }
    }
}
