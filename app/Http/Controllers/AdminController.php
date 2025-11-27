<?php

namespace App\Http\Controllers;

// Hapus Pengunjung dan SurveiKepuasan Model
// use App\Models\Pengunjung; 
// use App\Models\SurveiKepuasan;
use Google\Client;
use Google\Service\Sheets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;

class AdminController extends Controller
{
    private $sheetIdPengunjung;
    private $sheetIdSkm;
    private $sheetNamePengunjung = 'BukuTamu';
    private $sheetNameSkm = 'DataSKM'; 

    public function __construct()
    {
        // Ambil ID Sheets dari Config/Env untuk digunakan di seluruh controller
        $this->sheetIdPengunjung = Config::get('app.google_sheet_id_tamu', '1XKirvKDNNnwcauLTxHebHCcHbAdEHLZdL5caoB3HiVE');
        $this->sheetIdSkm = Config::get('app.google_sheet_id_skm', '1iTmYnrKDmx3lmoIjoEqeAkSlHE0aePXF56SGFqfl6J0');
    }

    // ============================
    // AUTH
    // ============================
    // Logika Auth tidak berubah karena Auth::attempt biasanya menggunakan tabel 'users'

    public function showLoginForm() 
    { 
        return view('admin.auth.login_admin'); 
    }
    
    public function login(Request $request)
    {
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
    
    public function logout(Request $request) 
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    }
    
    // ----------------------------------------------------
    
    // ============================
    // DASHBOARD (HITUNG DARI SHEET)
    // ============================

    public function dashboard() 
    { 
        $totalPengunjung = 0;
        $totalSkm = 0;
        $currentDate = Carbon::now();
        $currentMonthYear = $currentDate->translatedFormat('F Y')
        ;
        try {
            $service = $this->getGoogleSheetsService();

            // --- Hitung Pengunjung dari Sheet ---
            $rangeP = $this->sheetNamePengunjung . '!A:A'; 
            $responseP = $service->spreadsheets_values->get($this->sheetIdPengunjung, $rangeP);
            $valuesP = $responseP->getValues();
            if ($valuesP) {
                // Total = Jumlah baris - 1 (Header)
                $totalPengunjung = max(0, count($valuesP) - 1); 
            }

            // --- Hitung SKM dari Sheet ---
            $rangeS = $this->sheetNameSkm . '!A:A'; 
            $responseS = $service->spreadsheets_values->get($this->sheetIdSkm, $rangeS);
            $valuesS = $responseS->getValues();
            if ($valuesS) {
                // Total = Jumlah baris - 1 (Header)
                $totalSkm = max(0, count($valuesS) - 1); 
            }

        } catch (\Exception $e) {
            // Jika Google Sheets Gagal, total 0
            session()->flash('error', 'Gagal memuat data dashboard dari Google Sheets.');
        }

        return view('admin.dashboard_admin', [
            'total_pengunjung' => $totalPengunjung,
            'total_skm' => $totalSkm,
            'currentMonthYear' => $currentMonthYear,
        ]);
    }

    // ----------------------------------------------------

    // ============================
    // DATA VIEW (READ DARI SHEET)
    // ============================

    // dataPengunjung: Perlu diubah agar menggunakan logic di AdminPengunjungController::index
    // Namun, karena kode Anda memanggil AdminController::dataPengunjung, 
    // kita akan menyediakan implementasi dasar yang membaca data pengunjung dari sheets.
    public function dataPengunjung() 
    { 
        // NOTE: Sebaiknya fungsionalitas ini dipindahkan ke AdminPengunjungController::index
        // untuk konsistensi, tetapi di sini diimplementasikan agar AdminController lama bekerja.
        
        try {
            $service = $this->getGoogleSheetsService();
            // Ambil data dari baris ke-2 sampai kolom G (sesuai struktur AdminPengunjungController)
            $range = $this->sheetNamePengunjung . '!A2:G'; 
            $response = $service->spreadsheets_values->get($this->sheetIdPengunjung, $range);
            $rows = $response->getValues();

            $data = [];
            if (!empty($rows)) {
                foreach ($rows as $index => $row) {
                    $rowIndex = $index + 2; // ID = Row Index

                    $data[] = (object) [
                        'id' => $rowIndex, 
                        'tanggal' => $row[0] ?? '-',
                        'nama_nip' => $row[1] ?? '-',
                        'instansi' => $row[2] ?? '-',
                        'layanan' => $row[3] ?? '-',
                        'keperluan' => $row[4] ?? '-',
                        'no_hp' => $row[5] ?? '-',
                        'created_at' => $row[6] ?? '-',
                    ];
                }
            }

            // Urutkan terbaru di atas dan konversi ke Collection
            $pengunjung = collect(array_reverse($data));

        } catch (\Exception $e) {
             session()->flash('error', 'Gagal memuat data pengunjung dari Google Sheets.');
             $pengunjung = collect([]);
        }

        // Karena data tidak di-paginate, tampilan mungkin perlu disesuaikan 
        // (misal menghapus $pengunjung->links() di view)
        return view('admin.data_pengunjung', compact('pengunjung')); 
    }
    
    // dataSkmDemografi: Ambil data demografi langsung dari Sheet
    public function dataSkmDemografi() 
    { 
        try {
            $service = $this->getGoogleSheetsService();
            // Ambil kolom A sampai E (Demografi)
            $range = $this->sheetNameSkm . '!B2:F'; // <-- Ubah Range di sini

            $response = $service->spreadsheets_values->get($this->sheetIdSkm, $range);
            $rows = $response->getValues();

            $data = [];
            if (!empty($rows)) {
                foreach ($rows as $index => $row) {
                    $rowIndex = $index + 2; 

                    $data[] = (object) [
                        'id' => $rowIndex, 
                        'usia' => $row[0] ?? '-',             // Row index 0 (Sheet B)
                        'jenis_kelamin' => $row[1] ?? '-',    // Row index 1 (Sheet C)
                        'pendidikan_terakhir' => $row[2] ?? '-',// Row index 2 (Sheet D)
                        'pekerjaan' => $row[3] ?? '-',          // Row index 3 (Sheet E)
                        'jenis_layanan_diterima' => $row[4] ?? '-',// Row index 4 (Sheet F)
                    ];
                }
            }
            $skm = collect(array_reverse($data));
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal memuat data SKM (Demografi) dari Google Sheets.');
            $skm = collect([]);
        }

        return view('admin.skm.data_skm_demografi', compact('skm')); 
    }
    
    // dataSkmPertanyaan: Ambil data pertanyaan langsung dari Sheet
    public function dataSkmPertanyaan() 
    { 
        try {
            $service = $this->getGoogleSheetsService();
            // Ambil kolom A sampai O (termasuk Saran/Masukan)
            $range = $this->sheetNameSkm . '!A2:O'; 
            $response = $service->spreadsheets_values->get($this->sheetIdSkm, $range);
            $rows = $response->getValues();

            $data = [];
            if (!empty($rows)) {
                foreach ($rows as $index => $row) {
                    $rowIndex = $index + 2; 

                    // Mapping index column ke property name
                    $data[] = (object) [
                        'id' => $rowIndex,
                        'q1_persyaratan' => $row[5] ?? '-',
                        'q2_prosedur' => $row[6] ?? '-',
                        'q3_waktu' => $row[7] ?? '-',
                        'q4_biaya' => $row[8] ?? '-',
                        'q5_produk' => $row[9] ?? '-',
                        'q6_kompetensi_petugas' => $row[10] ?? '-',
                        'q7_perilaku_petugas' => $row[11] ?? '-',
                        'q8_penanganan_pengaduan' => $row[12] ?? '-',
                        'q9_sarana' => $row[13] ?? '-',
                        'saran_masukan' => $row[14] ?? '-',
                    ];
                }
            }
            $skm = collect(array_reverse($data));
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal memuat data SKM (Pertanyaan) dari Google Sheets.');
            $skm = collect([]);
        }

        return view('admin.skm.data_skm_pertanyaan', compact('skm')); 
    }

    // ----------------------------------------------------

    // ============================
    // LAPORAN (HITUNG DARI SHEET)
    // ============================

    public function laporan() 
    { 
        // Logika hitung total sudah di atas, kita gunakan kembali
        $totalPengunjung = 0;
        $totalSkm = 0;

        try {
            $service = $this->getGoogleSheetsService();
            
            // Hitung Pengunjung
            $rangeP = $this->sheetNamePengunjung . '!A:A'; 
            $valuesP = $service->spreadsheets_values->get($this->sheetIdPengunjung, $rangeP)->getValues();
            if ($valuesP) $totalPengunjung = max(0, count($valuesP) - 1);

            // Hitung SKM
            $rangeS = $this->sheetNameSkm . '!A:A'; 
            $valuesS = $service->spreadsheets_values->get($this->sheetIdSkm, $rangeS)->getValues();
            if ($valuesS) $totalSkm = max(0, count($valuesS) - 1);

        } catch (\Exception $e) {
            session()->flash('error', 'Gagal memuat data laporan dari Google Sheets.');
        }

        // Data demografi dikosongkan/disederhanakan untuk efisiensi
        $dataGender = [];
        $dataLayanan = [];
        $dataPendidikan = [];

        return view('admin.laporan', compact(
            'totalPengunjung',
            'totalSkm',
            'dataGender',
            'dataLayanan',
            'dataPendidikan'
        ));
    }

    // ----------------------------------------------------

    // ============================
    // DOWNLOAD (AMBIL SEMUA DATA DARI SHEET)
    // ============================

    public function downloadPengunjung()
    {
        try {
            $service = $this->getGoogleSheetsService();
            $spreadsheetId = $this->sheetIdPengunjung;

            // Ambil SEMUA data dari Sheet (termasuk header)
            $range = $this->sheetNamePengunjung . '!A:G'; 
            $response = $service->spreadsheets_values->get($spreadsheetId, $range);
            $data = $response->getValues();

            if (empty($data)) {
                 throw new \Exception("Data Pengunjung kosong di Google Sheet.");
            }

            // --- Tulis ulang ke Sheet yang sama untuk 'sinkronisasi' (tidak perlu, tapi mengikuti pola update) ---
            $body = new \Google\Service\Sheets\ValueRange(['values' => $data]);
            
            // Gunakan update untuk menimpa A1 dengan data yang sudah diambil
            $service->spreadsheets_values->update(
                $spreadsheetId,
                $this->sheetNamePengunjung . '!A1',
                $body,
                ['valueInputOption' => 'USER_ENTERED']
            );

            $sheetUrl = 'https://docs.google.com/spreadsheets/d/' . $spreadsheetId;

            return redirect()->route('admin.laporan')
                ->with('success', "Data Pengunjung berhasil di-sinkronisasi dari Sheet. <a href='{$sheetUrl}' target='_blank'>Klik untuk lihat/unduh</a>");

        } catch (\Exception $e) {
            return redirect()->route('admin.laporan')
                ->with('error', "Gagal update Pengunjung: " . $e->getMessage());
        }
    }


    public function downloadSkm()
    {
        try {
            $service = $this->getGoogleSheetsService();
            $spreadsheetId = $this->sheetIdSkm;

            // Ambil SEMUA data dari Sheet (termasuk header)
            $range = $this->sheetNameSkm . '!A:P'; // A-P mencakup semua data SKM
            $response = $service->spreadsheets_values->get($spreadsheetId, $range);
            $data = $response->getValues();

             if (empty($data)) {
                 throw new \Exception("Data SKM kosong di Google Sheet.");
            }
            
            // --- Tulis ulang ke Sheet yang sama ---
            $body = new \Google\Service\Sheets\ValueRange(['values' => $data]);

            // Gunakan update untuk menimpa A1 dengan data yang sudah diambil
            $service->spreadsheets_values->update(
                $spreadsheetId,
                $this->sheetNameSkm . '!A1',
                $body,
                ['valueInputOption' => 'USER_ENTERED']
            );

            $sheetUrl = 'https://docs.google.com/spreadsheets/d/' . $spreadsheetId;

            return redirect()->route('admin.laporan')
                ->with('success', "Data SKM berhasil di-sinkronisasi dari Sheet. <a href='{$sheetUrl}' target='_blank'>Klik untuk lihat/unduh</a>");

        } catch (\Exception $e) {
            return redirect()->route('admin.laporan')
                ->with('error', "Gagal update SKM: " . $e->getMessage());
        }
    }
    
    // ----------------------------------------------------

    // ============================
    // GOOGLE SHEETS HELPER
    // ============================

    private function getGoogleSheetsService()
    {
        $client = new Client();
        $credentialsFile = Config::get('app.google_service_account_credentials');

        if (empty($credentialsFile)) {
            $credentialsFile = 'credentials.json'; 
            $jsonCredentials = env('GOOGLE_CREDENTIALS_JSON');
        }

        $credentialPath = storage_path('app/' . $credentialsFile);

        if (!file_exists($credentialPath)) {
            if(file_exists(base_path($credentialsFile))) {
                $credentialPath = base_path($credentialsFile);
            } else {
                throw new \Exception("File credential tidak ditemukan.");
            }
        }

        $client->setAuthConfig($credentialPath);
        $client->setScopes([Sheets::SPREADSHEETS]);

        return new Sheets($client);
    }
}