<?php

namespace App\Http\Controllers;

use App\Models\Pengunjung;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Google\Client;
use Google\Service\Sheets;

class PengunjungController extends Controller
{
    // --- Tampilan Pengunjung ---
    
    public function onboard() { 
        return view('frontend.onboard'); 
    }

    public function dashboard() 
    { 
        $currentDate = Carbon::now();
        $currentMonthYear = $currentDate->translatedFormat('F Y'); 
        
        // Cek apakah database bisa diakses (untuk menghindari error di Vercel)
        try {
            $pengunjung = Pengunjung::whereMonth('tanggal', $currentDate->month)
                                    ->whereYear('tanggal', $currentDate->year)
                                    ->latest()
                                    ->get();
        } catch (\Exception $e) {
            // Jika database error/tidak bisa dibaca, kembalikan collection kosong
            $pengunjung = collect([]);
        }
        
        return view('buku_tamu.dashboard', compact('currentMonthYear', 'pengunjung')); 
    }

    public function showForm() { 
        return view('buku_tamu.isi_form'); 
    }

    public function thankYou() { 
        return view('frontend.telah_isi_form'); 
    }

    /**
     * Helper untuk koneksi Google Sheets Service.
     */
    private function getGoogleSheetsService()
    {
        $client = new Client();
        
        // Ambil nama file/path dari env atau config
        // Pastikan di Vercel Env Variable: GOOGLE_SERVICE_ACCOUNT_CREDENTIALS = /tmp/credentials.json
        $credentialsFile = env('GOOGLE_SERVICE_ACCOUNT_CREDENTIALS', Config::get('app.google_service_account_credentials'));

        if (empty($credentialsFile)) {
            throw new \Exception("GOOGLE_SERVICE_ACCOUNT_CREDENTIALS tidak terdefinisi.");
        }
        
        // --- PERBAIKAN PATH CREDENTIALS ---
        // Cek apakah path diawali '/' (Absolute path, contoh: /tmp/credentials.json)
        if (str_starts_with($credentialsFile, '/') || str_contains($credentialsFile, 'tmp')) {
             $credentialPath = $credentialsFile; // Gunakan langsung (untuk Vercel)
        } else {
             // Jika tidak, asumsikan ada di storage local (untuk Laptop/Localhost)
             $credentialPath = storage_path('app/' . $credentialsFile);
        }

        if (!file_exists($credentialPath)) {
            throw new \Exception("File kredensial tidak ditemukan di: " . $credentialPath);
        }

        $client->setAuthConfig($credentialPath);
        $client->setScopes([Sheets::SPREADSHEETS]);
        return new Sheets($client);
    }


    /**
     * Menyimpan data buku tamu ke database dan Google Sheets.
     */
    public function store(Request $request)
    {
        // Validasi input form
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'nama_nip' => 'required|string|max:255',
            'instansi' => 'required|string|max:255',
            'layanan' => 'required|string|max:255',
            'keperluan' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
        ]);

        try {
            // --- MODIFIKASI UNTUK VERCEL ---
            
            // Buat objek Pengunjung di Memory (RAM) saja dulu
            // Jangan langsung ::create() karena akan mencoba menulis ke DB
            $pengunjung = new Pengunjung($validated);

            // Cek Environment
            if (env('APP_ENV') === 'production') {
                // DI VERCEL: KITA SKIP SIMPAN DB AGAR TIDAK ERROR READ-ONLY
                // Kita beri ID palsu/random agar session tidak error
                $pengunjung->id = rand(10000, 99999); 
            } else {
                // DI LOCALHOST: Simpan ke Database seperti biasa
                $pengunjung->save();
            }
            
            // 2. Kirim Data ke Google Sheets (Ini Prioritas Utama)
            $this->exportToGoogleSheets($pengunjung);
            
            // Simpan ID Pengunjung di session untuk survey selanjutnya
            session(['current_pengunjung_id' => $pengunjung->id]);
            
            // 3. Redirect ke halaman terima kasih
            return redirect()->route('buku-tamu.thank-you');

        } catch (\Exception $e) {
            return back()->withInput()->withErrors('Gagal menyimpan data. Error: ' . $e->getMessage());
        }
    }
    
    /**
     * Menambahkan satu baris data pengunjung ke Google Sheets.
     */
    private function exportToGoogleSheets(Pengunjung $pengunjung)
    {
        $service = $this->getGoogleSheetsService();
        $spreadsheetId = env('GOOGLE_SHEET_ID_TAMU', Config::get('app.google_sheet_id_tamu'));

        if (empty($spreadsheetId)) {
            throw new \Exception("GOOGLE_SHEET_ID_TAMU kosong.");
        }

        // Data yang akan ditambahkan ke baris baru
        $rowData = [
            $pengunjung->tanggal,
            $pengunjung->nama_nip,
            $pengunjung->instansi,
            $pengunjung->layanan,
            $pengunjung->keperluan,
            $pengunjung->no_hp,
            now()->toDateTimeString()
        ];
        
        // Range 'BukuTamu' (pastikan nama sheet ini ada di Spreadsheet Anda)
        $range = 'BukuTamu'; // Sesuaikan dengan nama Tab di bawah spreadsheet (Sheet1 atau BukuTamu)
        $body = new \Google\Service\Sheets\ValueRange(['values' => [$rowData]]);
        
        // Menggunakan append
        $service->spreadsheets_values->append(
            $spreadsheetId,
            $range,
            $body,
            ['valueInputOption' => 'USER_ENTERED', 'insertDataOption' => 'INSERT_ROWS']
        );
    }
}