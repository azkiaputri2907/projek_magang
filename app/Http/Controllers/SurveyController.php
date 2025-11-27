<?php

namespace App\Http\Controllers;

use App\Models\Pengunjung;
use App\Models\SurveiKepuasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon; 
use Google\Client;
use Google\Service\Sheets;
use Google\Service\Sheets\ValueRange;

class SurveyController extends Controller
{
    // --- Tampilan Survey ---
    
    public function ajakan() 
    { 
        return view('frontend.setelah_pelayanan'); 
    }
    
    public function showDataDiriForm() 
    { 
        return view('survey.form_kepuasan_1'); 
    }
    
    public function showLayananForm() 
    { 
        return view('survey.form_kepuasan_2'); 
    }
    
    public function showPetugasForm() 
    { 
        return view('survey.form_kepuasan_3'); 
    }
    
    public function thankYou() 
    { 
        return view('frontend.telah_isi_survey'); 
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
     * Menyimpan data SKM ke database dan Google Sheets.
     */
    public function store(Request $request)
    {
        // Ambil data pengunjung ID dari session/hidden field
        $pengunjungId = session('current_pengunjung_id') ?? $request->pengunjung_id;
        
        // --- LOGIKA PENGUNJUNG (Updated for Vercel) ---
        $pengunjung = null;

        if (env('APP_ENV') === 'production') {
            // DI VERCEL: Kita tidak bisa cek database karena data pengunjung sebelumnya tidak disimpan di DB.
            // Kita percaya saja pada session ID yang ada.
            if (!$pengunjungId) {
                return redirect('/')->withErrors('Sesi Pengunjung hilang. Silakan isi buku tamu ulang.');
            }
            // Buat dummy object untuk menghindari error null reference nanti
            $pengunjung = new Pengunjung();
            $pengunjung->id = $pengunjungId;
        } else {
            // DI LOCALHOST: Cek validitas ID di database
            $pengunjung = Pengunjung::find($pengunjungId);
            if (!$pengunjung) {
                return redirect('/')->withErrors('Sesi Pengunjung tidak ditemukan atau sudah kadaluarsa.');
            }
        }
        
        // Validasi dan gabungkan semua data dari form 1, 2, dan 3
        $validated = $request->validate([
            // Demografi
            'usia' => 'required|integer',
            'jenis_kelamin' => 'required|string',
            'pendidikan_terakhir' => 'required|string',
            'pekerjaan' => 'required|string',
            'jenis_layanan_diterima' => 'required|string',
            
            // Pertanyaan Layanan (Q1-Q5)
            'q1_persyaratan' => 'required|integer|min:1|max:4',
            'q2_prosedur' => 'required|integer|min:1|max:4',
            'q3_waktu' => 'required|integer|min:1|max:4',
            'q4_biaya' => 'required|integer|min:1|max:4',
            'q5_produk' => 'required|integer|min:1|max:4',
            
            // Pertanyaan Petugas & Sarana (Q6-Q9)
            'q6_kompetensi_petugas' => 'required|integer|min:1|max:4',
            'q7_perilaku_petugas' => 'required|integer|min:1|max:4',
            'q8_penanganan_pengaduan' => 'required|integer|min:1|max:4',
            'q9_sarana' => 'required|integer|min:1|max:4',
            'saran_masukan' => 'nullable|string',
        ]);
        
        try {
            // --- MODIFIKASI UNTUK VERCEL ---
            
            // 1. Siapkan Objek Survey (Memory Only)
            // Kita gunakan new SurveiKepuasan() alih-alih create() agar tidak auto-save
            $validated['pengunjung_id'] = $pengunjungId;
            $survey = new SurveiKepuasan($validated);

            // Cek Environment
            if (env('APP_ENV') === 'production') {
                // DI VERCEL: SKIP Save DB & Update Pengunjung
                // Langsung lanjut ke Google Sheets
            } else {
                // DI LOCALHOST: Simpan normal
                $survey->save(); 
                
                // Update status pengunjung
                if ($pengunjung && $pengunjung->exists) {
                    $pengunjung->update(['sudah_survey' => true]);
                }
            }

            // 2. Kirim Data ke Google Sheets (Survei Kepuasan)
            // Ini prioritas utama di Vercel
            $this->exportToGoogleSheets($survey);

            // 4. Bersihkan session
            session()->forget('current_pengunjung_id');

            // 5. Redirect ke halaman terima kasih survey
            return redirect()->route('survey.thank-you');

        } catch (\Exception $e) {
            return back()->withInput()->withErrors('Gagal menyimpan data SKM. Error: ' . $e->getMessage());
        }
    }
    
    /**
     * Menambahkan satu baris data survei kepuasan ke Google Sheets (DataSKM).
     */
    private function exportToGoogleSheets(SurveiKepuasan $survey)
    {
        $service = $this->getGoogleSheetsService();
        $spreadsheetId = env('GOOGLE_SHEET_ID_SKM', Config::get('app.google_sheet_id_skm'));

        if (empty($spreadsheetId)) {
            throw new \Exception("GOOGLE_SHEET_ID_SKM kosong.");
        }

        // Data yang akan ditambahkan ke baris baru
        $rowData = [
            Carbon::now()->toDateTimeString(),
            $survey->pengunjung_id,
            $survey->usia,
            $survey->jenis_kelamin,
            $survey->pendidikan_terakhir,
            $survey->pekerjaan,
            $survey->jenis_layanan_diterima,
            $survey->q1_persyaratan,
            $survey->q2_prosedur,
            $survey->q3_waktu,
            $survey->q4_biaya,
            $survey->q5_produk,
            $survey->q6_kompetensi_petugas,
            $survey->q7_perilaku_petugas,
            $survey->q8_penanganan_pengaduan,
            $survey->q9_sarana,
            $survey->saran_masukan ?? '',
        ];
        
        // Range 'DataSKM'
        $range = 'DataSKM'; 
        $body = new ValueRange(['values' => [$rowData]]);
        
        $service->spreadsheets_values->append(
            $spreadsheetId,
            $range,
            $body,
            ['valueInputOption' => 'USER_ENTERED', 'insertDataOption' => 'INSERT_ROWS']
        );
    }
}