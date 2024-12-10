<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Medicine;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrderExport;


class OrderController extends Controller
{

    public function exportExcel()
    {
        return Excel::download(new OrderExport, 'rekap-pembelian.xlsx');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $orders = Order::where('user_id', Auth::user()->id)
            ->where('created_at', 'LIKE', '%' . $request->search_data_pembelian . '%')
            ->simplePaginate(5);

        // Menambahkan parameter pencarian ke paginasi agar tetap ada di URL saat berpindah halaman
        $orders->appends(['search_data_pembelian' => $request->search_data_pembelian]);

        return view('order.kasir.kasir', compact('orders'));
    }

    public function indexAdmin(Request $request)
    {
        $orders = Order::with('user')->where('created_at', 'LIKE', '%' . $request->search_data_pembelian . '%')
            ->simplePaginate(5);

        // Menambahkan parameter pencarian ke paginasi agar tetap ada di URL saat berpindah halaman
        $orders->appends(['search_data_pembelian' => $request->search_data_pembelian]);

        return view('order.admin.data', compact('orders'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $medicines = Medicine::all();
        return view('order.kasir.form', compact('medicines'));
    }


    public function store(Request $request)
    {
        // Validasi data request
        $request->validate([
            "name_customer" => "required",
            "medicines" => "required"
        ]);

        // Mencari values array yang datanya sama
        $arrayValues = array_count_values($request->medicines);
        $arrayNewMedicines = [];

        // Looping array data duplikat
        foreach ($arrayValues as $key => $value) {
            $medicine = Medicine::where('id', $key)->first();

            // Cek ketersediaan stok
            if ($medicine['stock'] < $value) {
                return redirect()->back()->withInput()->with('failed', 'Stock Obat ' . $medicine['name'] . ' Tidak Cukup');
            } else {
                $medicine['stock'] -= $value;
                $medicine->save();
            }

            // Menghitung total harga tiap item
            $totalPrice = $medicine['price'] * $value;
            $arrayItem = [
                "id" => $key,
                "name_medicine" => $medicine['name'],
                "qyt" => $value,
                "price" => $medicine['price'],
                "total_price" => $totalPrice
            ];

            array_push($arrayNewMedicines, $arrayItem);
        }

        // Menghitung total harga sebelum PPN
        $total = array_sum(array_column($arrayNewMedicines, 'total_price'));

        // Menghitung PPN 10%
        $tax = $total * 0.10;
        $totalWithTax = $total + $tax;

        // Menyimpan data order ke database
        $orders = Order::create([
            'user_id' => Auth::user()->id,
            'medicines' => $arrayNewMedicines,
            'name_customer' => $request->name_customer,
            'total_price' => $totalWithTax
        ]);

        if ($orders) {
            $result = Order::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->first();
            return redirect()->route('pembelian.print', $result['id'])->with('success', "Berhasil Order");
        } else {
            return redirect()->back()->with('failed', "Gagal Order");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order, $id)
    {
        $order = Order::find($id);

        // Pass only the total_price (which includes the tax) to the view
        $totalPrice = $order->total_price / 1.1; // This is the price before tax
        // Remove the calculation for the tax in the controller

        return view('order.kasir.print', compact('order', 'totalPrice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }

    public function downloadPDF($id)
    {
        $order = Order::where('id', $id)->first()->toArray();
        //nama variabel yang akan di gunakan di pdf
        view()->share('order', $order);
        //panggil file blade yang akan di ubah menjadi pdf
        $pdf = Pdf::loadView('order.kasir.pdf', $order);
        //proses download dan nama file nya
        return $pdf->download('struk-pembelian.pdf');
    }
}
