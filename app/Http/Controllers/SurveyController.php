<?php

namespace App\Http\Controllers;

use App\Models\Pengunjung;
use App\Models\SurveiKepuasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon; // DITAMBAHKAN untuk penggunaan waktu yang eksplisit
use Google\Client;
use Google\Service\Sheets;
use Google\Service\Sheets\ValueRange; // Digunakan untuk ValueRange body

class SurveyController extends Controller
{
    // --- Tampilan Survey (View Path disesuaikan) ---
    
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
        // Pastikan nama konfigurasi ini sesuai dengan yang Anda gunakan di .env/config
        $credentialsFile = Config::get('app.google_service_account_credentials');

        if (empty($credentialsFile)) {
            throw new \Exception("GOOGLE_SERVICE_ACCOUNT_CREDENTIALS tidak terdefinisi di konfigurasi.");
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
     * Menyimpan data SKM ke database dan Google Sheets.
     */
    public function store(Request $request)
    {
        // Ambil data pengunjung ID dari session/hidden field
        $pengunjungId = session('current_pengunjung_id') ?? $request->pengunjung_id;
        $pengunjung = Pengunjung::find($pengunjungId);

        if (!$pengunjung) {
            return redirect('/')->withErrors('Sesi Pengunjung tidak ditemukan atau sudah kadaluarsa.');
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
            // 1. Simpan ke Database
            $validated['pengunjung_id'] = $pengunjungId;
            $survey = SurveiKepuasan::create($validated); // Ambil instance model yang baru dibuat

            // 2. Kirim Data ke Google Sheets (Survei Kepuasan)
            $this->exportToGoogleSheets($survey);

            // 3. Update status pengunjung
            $pengunjung->update(['sudah_survey' => true]);

            // 4. Bersihkan session
            session()->forget('current_pengunjung_id');

            // 5. Redirect ke halaman terima kasih survey
            return redirect()->route('survey.thank-you');

        } catch (\Exception $e) {
            // Jika ada error (Database atau Google Sheets)
            // Catatan: Pastikan Service Account memiliki akses 'Editor' ke Spreadsheet Anda.
            return back()->withInput()->withErrors('Gagal menyimpan data SKM. Pastikan konfigurasi Google Sheets sudah benar dan Service Account memiliki akses \'Editor\'. Error: ' . 
            $e->getMessage());
        }
    }
    
    /**
     * Menambahkan satu baris data survei kepuasan ke Google Sheets (DataSKM).
     */
    private function exportToGoogleSheets(SurveiKepuasan $survey)
    {
        $service = $this->getGoogleSheetsService();
        // ASUMSI: Menggunakan konfigurasi ID sheet yang berbeda untuk data SKM
        $spreadsheetId = Config::get('app.google_sheet_id_skm');

        if (empty($spreadsheetId)) {
            throw new \Exception("GOOGLE_SHEET_ID_SKM tidak terdefinisi atau kosong di konfigurasi (misalnya .env).");
        }

        // Data yang akan ditambahkan ke baris baru, sesuaikan urutan kolom di sheet DataSKM Anda
        $rowData = [
            Carbon::now()->toDateTimeString(), // Perbaikan: Menggunakan Carbon::now()
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
        
        // Range 'DataSKM' (Sesuai permintaan Anda)
        $range = 'DataSKM'; 
        $body = new ValueRange(['values' => [$rowData]]);
        
        // Menggunakan append untuk menambahkan baris baru tanpa menimpa data
        $service->spreadsheets_values->append(
            $spreadsheetId,
            $range,
            $body,
            ['valueInputOption' => 'USER_ENTERED', 'insertDataOption' => 'INSERT_ROWS']
        );
    }
}