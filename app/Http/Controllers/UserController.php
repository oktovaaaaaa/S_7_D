<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Keranjang;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\CoreApi;
use Midtrans\Notification; // Tambahkan ini untuk callback
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    public function daftarMenu()
    {
        $menus = Menu::all();
        return view('userr.menu', compact('menus'));
    }

    public function tampilDetailMenu(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);
        return view('userr.detail_menu', compact('menu'));
    }

    public function tambahKeKeranjang(Request $request, $menuId)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        $menu = Menu::findOrFail($menuId);
        $jumlah = $request->input('jumlah');
        $hargaSatuan = str_replace(['Rp', '.'], '', $menu->harga);
        $hargaSatuan = (int)preg_replace('/[^0-9]/', '', $hargaSatuan);
        $totalHarga = $hargaSatuan * $jumlah;

        Keranjang::create([
            'user_id' => Auth::id(),
            'menu_id' => $menuId,
            'jumlah' => $jumlah,
            'total_harga' => $totalHarga,
        ]);

        return redirect()->route('userr.menu')->with('success', 'Menu berhasil ditambahkan ke keranjang!');
    }
    public function lihatKeranjang()
    {
        $keranjangItems = Keranjang::where('user_id', Auth::id())->get();
        return view('userr.keranjang', compact('keranjangItems'));
    }

    public function hapusDariKeranjang($id)
    {
        $keranjangItem = Keranjang::findOrFail($id);

        // Pastikan hanya user yang punya item yang bisa menghapus
        if ($keranjangItem->user_id != Auth::id()) {
            return redirect()->route('userr.keranjang')->with('error', 'Anda tidak memiliki izin untuk menghapus item ini.');
        }

        $keranjangItem->delete();
        return redirect()->route('userr.keranjang')->with('success', 'Item berhasil dihapus dari keranjang.');
    }
    public function prosesPembayaran(Request $request)
    {
        // Validasi request
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        // Ambil data dari request
        $menuId = $request->input('menu_id');
        $jumlah = $request->input('jumlah');

        // Ambil data menu dari database
        $menu = Menu::findOrFail($menuId);
        $hargaSatuan = str_replace(['Rp', '.'], '', $menu->harga);
        $hargaSatuan = (int)preg_replace('/[^0-9]/', '', $hargaSatuan);
        $totalHarga = $hargaSatuan * $jumlah;

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // Buat daftar menu yang dipesan
            $daftarMenu = [
                [
                    'nama' => $menu->nama,
                    'jumlah' => $jumlah,
                    'harga_satuan' => $hargaSatuan,
                ]
            ];

            // Simpan data pesanan ke tabel 'pesanans'
            $pesanan = Pesanan::create([
                'user_id' => Auth::id(),
                'daftar_menu' => json_encode($daftarMenu),
                'total_harga' => $totalHarga,
                'status' => 'pending',
            ]);

            // Konfigurasi Midtrans
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = true;
            Config::$is3ds = true;

            // Buat parameter transaksi Midtrans
            $params = [
                'transaction_details' => [
                    'order_id' => 'DELCAFE-' . $pesanan->id . '-' . time(), // Order ID unik
                    'gross_amount' => $totalHarga,
                ],
                'customer_details' => [
                    'name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                ],
            ];

            // Dapatkan snap token
            $snapToken = Snap::getSnapToken($params);

            // Commit transaksi database
            DB::commit();

            // Redirect ke halaman pembayaran Midtrans (View)
            return response()->json([
                'snapToken' => $snapToken,
                'pesanan_id' => $pesanan->id,
                'total_harga' => $totalHarga,
            ]);

        } catch (\Exception $e) {
            // Rollback transaksi database jika terjadi kesalahan
            DB::rollback();

            // Tangani error Midtrans
            return redirect()->route('userr.menu')->with('error', 'Terjadi kesalahan saat memproses pembayaran: ' . $e->getMessage());
        }
    }

    public function prosesPembayaranKeranjang()
    {
        $keranjangItems = Keranjang::where('user_id', Auth::id())->get();

        if ($keranjangItems->isEmpty()) {
            return response()->json(['error' => 'Keranjang Anda kosong.'], 400); // Ganti redirect dengan response JSON
        }

        $totalHarga = $keranjangItems->sum('total_harga');

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // Menyimpan data pesanan ke tabel 'pesanans'
            $daftarMenu = [];
            foreach ($keranjangItems as $item) {
                try {
                    $menu = Menu::findOrFail($item->menu_id);
                    $hargaSatuan = str_replace(['Rp', '.'], '', $menu->harga);
                    $hargaSatuan = (int)preg_replace('/[^0-9]/', '', $hargaSatuan);

                    $daftarMenu[] = [
                        'nama' => $item->menu->nama,
                        'jumlah' => $item->jumlah,
                        'harga_satuan' => $hargaSatuan,
                    ];
                } catch (\Exception $e) {
                    DB::rollback();
                    \Log::error("Error saat memproses item keranjang (menu_id: {$item->menu_id}): " . $e->getMessage() . "\n" . $e->getTraceAsString());
                    return response()->json(['error' => 'Terjadi kesalahan saat memproses item di keranjang.'], 500);
                }
            }

            $pesanan = Pesanan::create([
                'user_id' => Auth::id(),
                'daftar_menu' => json_encode($daftarMenu),
                'total_harga' => $totalHarga,
                'status' => 'pending',
            ]);

            // Konfigurasi Midtrans
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = true;
            Config::$is3ds = true;

            // Buat parameter transaksi Midtrans
            $params = [
                'transaction_details' => [
                    'order_id' => 'DELCAFE-' . $pesanan->id . '-' . time(),
                    'gross_amount' => $totalHarga,
                ],
                'customer_details' => [
                    'name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                ],
            ];

            // Dapatkan snap token
            $snapToken = Snap::getSnapToken($params);

            // Commit transaksi database
            DB::commit();

            // Kosongkan keranjang setelah pesanan dibuat
            Keranjang::where('user_id', Auth::id())->delete();

            // Redirect ke halaman pembayaran Midtrans (View)
            return response()->json([
                'snapToken' => $snapToken,
                'pesanan_id' => $pesanan->id,
                'total_harga' => $totalHarga,
            ]);


        } catch (\Exception $e) {
            // Rollback transaksi database jika terjadi kesalahan
            DB::rollback();

            \Log::error("Error saat memproses pembayaran keranjang: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            return response()->json(['error' => 'Terjadi kesalahan saat memproses pembayaran keranjang.'], 500);
        }
    }

    public function midtransCallback(Request $request)
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $notification = new Notification();

        $transaction = $notification->transaction_status;
        $fraud = $notification->fraud_status;
        $orderId = $notification->order_id;

        // Pisahkan ID Pesanan dari Order ID Midtrans (asumsi format: DELCAFE-{ID Pesanan}-{timestamp})
        $orderParts = explode('-', $orderId);
        $pesananId = (int) $orderParts[1];

        // Cari Pesanan berdasarkan ID
        $pesanan = Pesanan::find($pesananId);

        if (!$pesanan) {
            // Log kesalahan atau tangani jika pesanan tidak ditemukan
            return response('Pesanan tidak ditemukan', 404);
        }

        if ($transaction == 'capture') {
            // For credit card transaction, we need to check whether transaction is challenge by FDS or not
            if ($fraud == 'challenge') {
                // TODO set payment status in merchant's database to 'Challenge by FDS'
                // and response to Midtrans with 200 OK
                $pesanan->status = 'challenge';
            } else if ($fraud == 'accept') {
                // TODO set payment status in merchant's database to 'Success'
                // and response to Midtrans with 200 OK
                $pesanan->status = 'dibayar';
            }
        } else if ($transaction == 'settlement') {
            // TODO set payment status in merchant's database to 'Settlement'
            // and response to Midtrans with 200 OK
            $pesanan->status = 'selesai';
        } else if ($transaction == 'cancel' || $transaction == 'deny' || $transaction == 'expire') {
            // TODO set payment status in merchant's database to 'Failure'
            // and response to Midtrans with 200 OK
            $pesanan->status = 'gagal';
        } else if ($transaction == 'pending') {
            // TODO set payment status in merchant's database to 'Pending'
            // and response to Midtrans with 200 OK
            $pesanan->status = 'pending';
        }

        $pesanan->save();

        return response('OK', 200);
    }

    public function lihatRiwayatPesanan()
    {
        $riwayatPesanan = Pesanan::where('user_id', Auth::id())->get();
        return view('userr.riwayat_pesanan', compact('riwayatPesanan'));
    }

    public function hapusRiwayatPesanan($id)
    {
        $pesanan = Pesanan::findOrFail($id);

        // Pastikan hanya user yang punya pesanan yang bisa menghapus
        if ($pesanan->user_id != Auth::id()) {
            return redirect()->route('userr.riwayatPesanan')->with('error', 'Anda tidak memiliki izin untuk menghapus pesanan ini.');
        }

        $pesanan->delete();
        return redirect()->route('userr.riwayatPesanan')->with('success', 'Pesanan berhasil dihapus.');
    }
}
