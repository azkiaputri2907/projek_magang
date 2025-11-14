<?php

namespace App\Http\Controllers;

use App\Models\Pengunjung;
use App\Models\SurveiKepuasan;
use Google\Client;
use Google\Service\Sheets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config; // Tambahkan ini untuk akses Config yang lebih eksplisit

class AdminController extends Controller
{
    // --- Autentikasi ---
    
    /**
     * Menampilkan form login admin.
     */
    public function showLoginForm() 
    { 
        return view('admin.auth.login_admin'); 
    }
    
    /**
     * Proses login admin.
     */
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }
        return back()->withErrors(['email' => 'Kredensial tidak valid.']);
    }
    
    /**
     * Proses logout admin.
     */
    public function logout(Request $request) 
    {
        Auth::logout();
        // Use the global request() helper to ensure session methods work even if $request isn't available
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    }
    
    // --- Tampilan Admin ---
    
    /**
     * Menampilkan dashboard admin.
     */
    public function dashboard() 
    { 
        $data = [
            'total_pengunjung' => Pengunjung::count(),
            'total_skm' => SurveiKepuasan::count()
        ];

        
        return view('admin.dashboard_admin', $data); 
    }
    
    /**
     * Menampilkan data pengunjung (Buku Tamu).
     */
    public function dataPengunjung() 
    { 
        $pengunjung = Pengunjung::latest()->paginate(10);
        return view('admin.data_pengunjung', compact('pengunjung')); 
    }
    
    /**
     * Menampilkan data SKM (demografi).
     */
    public function dataSkmDemografi() 
    { 
        $skm = SurveiKepuasan::with('pengunjung')->latest()->paginate(10);
        return view('admin.skm.data_skm_demografi', compact('skm')); 
    }
    
    /**
     * Menampilkan data SKM (jawaban pertanyaan).
     */
    public function dataSkmPertanyaan() 
    { 
        $skm = SurveiKepuasan::latest()->paginate(10);
        return view('admin.skm.data_skm_pertanyaan', compact('skm')); 
    }
    
    /**
     * Menampilkan halaman laporan.
     */
    public function laporan() 
    { 
        return view('admin.laporan'); 
    }

    // --- Fungsionalitas Google Sheets ---
    
    /**
     * Mendapatkan instance Google Sheets Service.
     */
    private function getGoogleSheetsService()
    {
        $client = new Client();
        
        // Gunakan Config::get untuk memastikan akses ke config/app.php
        $credentialsFile = Config::get('app.google_service_account_credentials');

        // Pastikan nama key konfigurasi yang di-throw sesuai
        if (empty($credentialsFile)) {
             throw new \Exception("Key 'google_service_account_credentials' (ENV: GOOGLE_SERVICE_ACCOUNT_CREDENTIALS) tidak terdefinisi di konfigurasi.");
        }
        
        $credentialPath = storage_path('app/' . $credentialsFile);

        if (!file_exists($credentialPath)) {
            throw new \Exception("File kredensial Google Service Account tidak ditemukan di: " . $credentialPath);
        }

        $client->setAuthConfig($credentialPath);
        $client->setScopes([Sheets::SPREADSHEETS]);
        return new Sheets($client);
    }

    /**
     * Mengunduh/Update data pengunjung ke Google Sheets.
     */
    public function downloadPengunjung()
    {
        try {
            $service = $this->getGoogleSheetsService();
            $spreadsheetId = Config::get('app.google_sheet_id_tamu');

            // Pastikan nama key konfigurasi yang di-throw sesuai
            if (empty($spreadsheetId)) {
                throw new \Exception("Key 'google_sheet_id_tamu' (ENV: GOOGLE_SHEET_ID_TAMU) tidak terdefinisi atau kosong di konfigurasi.");
            }

            // 1. Persiapkan Data dari Database
            $data = Pengunjung::select('tanggal', 'nama_nip', 'instansi', 'layanan', 'keperluan', 'no_hp', 'created_at')->get()->toArray();
            
            // Tambahkan Header
            $header = ['Tanggal', 'Nama/NIP', 'Instansi', 'Layanan', 'Keperluan', 'No. HP', 'Waktu Input'];
            array_unshift($data, $header);

            // 2. Tulis ke Google Sheets
            $range = 'BukuTamu!A1';
            $body = new \Google\Service\Sheets\ValueRange(['values' => $data]);
            $service->spreadsheets_values->update(
                $spreadsheetId,
                $range,
                $body,
                ['valueInputOption' => 'USER_ENTERED']
            );

            // 3. Beri tautan unduhan
            $sheetUrl = 'https://docs.google.com/spreadsheets/d/' . $spreadsheetId;
            return redirect()->route('admin.laporan')->with('success', "Data Pengunjung berhasil diperbarui di Google Sheet! <a href='{$sheetUrl}' target='_blank'>Lihat/Unduh di sini</a>");
            
        } catch (\Exception $e) {
            return redirect()->route('admin.laporan')->with('error', "Gagal mengunduh data Pengunjung ke Sheets. Error: " . $e->getMessage());
        }
    }

    /**
     * Mengunduh/Update data SKM ke Google Sheets.
     */
    public function downloadSkm()
    {
        try {
            $service = $this->getGoogleSheetsService();
            $spreadsheetId = Config::get('app.google_sheet_id_skm');

            // Pastikan nama key konfigurasi yang di-throw sesuai
            if (empty($spreadsheetId)) {
                throw new \Exception("Key 'google_sheet_id_skm' (ENV: GOOGLE_SHEET_ID_SKM) tidak terdefinisi atau kosong di konfigurasi.");
            }

            // 1. Persiapkan Data dari Database
            $data = SurveiKepuasan::select([
                'usia', 'jenis_kelamin', 'pendidikan_terakhir', 'pekerjaan', 'jenis_layanan_diterima',
                'q1_persyaratan', 'q2_prosedur', 'q3_waktu', 'q4_biaya', 'q5_produk',
                'q6_kompetensi_petugas', 'q7_perilaku_petugas', 'q8_penanganan_pengaduan', 'q9_sarana',
                'saran_masukan', 'created_at'
            ])->get()->toArray();
            
            // Tambahkan Header
            $header = ['Usia', 'JK', 'Pendidikan', 'Pekerjaan', 'Layanan', 'Q1', 'Q2', 'Q3', 'Q4', 'Q5', 'Q6', 'Q7', 'Q8', 'Q9', 'Saran', 'Waktu Input'];
            array_unshift($data, $header);

            // 2. Tulis ke Google Sheets
            $range = 'DataSKM!A1'; // Sheet Name dan Cell Start
            $body = new \Google\Service\Sheets\ValueRange(['values' => $data]);
            $service->spreadsheets_values->update(
                $spreadsheetId,
                $range,
                $body,
                ['valueInputOption' => 'USER_ENTERED']
            );

            // 3. Beri tautan unduhan
            $sheetUrl = 'https://docs.google.com/spreadsheets/d/' . $spreadsheetId;
            return redirect()->route('admin.laporan')->with('success', "Data SKM berhasil diperbarui di Google Sheet! <a href='{$sheetUrl}' target='_blank'>Lihat/Unduh di sini</a>");
            
        } catch (\Exception $e) {
            return redirect()->route('admin.laporan')->with('error', "Gagal mengunduh data SKM ke Sheets. Error: " . $e->getMessage());
        }
    }
    
}