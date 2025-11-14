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
        
        // Ambil data pengunjung untuk bulan dan tahun saat ini
        $pengunjung = Pengunjung::whereMonth('tanggal', $currentDate->month)
                                 ->whereYear('tanggal', $currentDate->year)
                                 ->latest()
                                 ->get();
        
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
        
        $credentialsFile = Config::get('app.google_service_account_credentials');

        if (empty($credentialsFile)) {
            throw new \Exception("GOOGLE_SERVICE_ACCOUNT_CREDENTIALS tidak terdefinisi.");
        }
        
        // Menggunakan storage_path() untuk mendapatkan path absolut
        $credentialPath = storage_path('app/' . $credentialsFile);

        if (!file_exists($credentialPath)) {
            throw new \Exception("File kredensial Google Service Account tidak ditemukan di: " . $credentialPath);
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
            // 1. Simpan ke Database
            $pengunjung = Pengunjung::create($validated);
            
            // 2. Kirim Data ke Google Sheets
            $this->exportToGoogleSheets($pengunjung);
            
            // Simpan ID Pengunjung di session untuk survey selanjutnya
            session(['current_pengunjung_id' => $pengunjung->id]);
            
            // 3. Redirect ke halaman terima kasih
            return redirect()->route('buku-tamu.thank-you');

        } catch (\Exception $e) {
            // Jika terjadi error, kirim pesan error yang jelas
            // Catatan: Pastikan Service Account memiliki akses 'Editor' ke Spreadsheet Anda.
            
            return back()->withInput()->withErrors('Gagal menyimpan data buku tamu. Error Sheets: ' . $e->getMessage());
        }
    }
    
    /**
     * Menambahkan satu baris data pengunjung ke Google Sheets.
     */
    private function exportToGoogleSheets(Pengunjung $pengunjung)
    {
        $service = $this->getGoogleSheetsService();
        $spreadsheetId = Config::get('app.google_sheet_id_tamu');

        if (empty($spreadsheetId)) {
            throw new \Exception("GOOGLE_SHEET_ID_TAMU tidak terdefinisi atau kosong di konfigurasi.");
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
        $range = 'BukuTamu'; 
        $body = new \Google\Service\Sheets\ValueRange(['values' => [$rowData]]);
        
        // Menggunakan append untuk menambahkan baris baru tanpa menimpa data
        $service->spreadsheets_values->append(
            $spreadsheetId,
            $range,
            $body,
            ['valueInputOption' => 'USER_ENTERED', 'insertDataOption' => 'INSERT_ROWS']
        );
    }
}