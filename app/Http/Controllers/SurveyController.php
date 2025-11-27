<?php

namespace App\Http\Controllers;

use App\Models\Pengunjung;
use App\Models\SurveiKepuasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
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
        
        // Cek Variable Environment di Vercel
        $credentialsFile = env('GOOGLE_SERVICE_ACCOUNT_CREDENTIALS', Config::get('app.google_service_account_credentials'));

        if (empty($credentialsFile)) {
            // DEBUG: Matikan aplikasi dan tampilkan pesan jika env kosong
            dd("Error Config: GOOGLE_SERVICE_ACCOUNT_CREDENTIALS kosong. Cek Environment Variable Vercel.");
        }
        
        // Logika Path
        if (str_starts_with($credentialsFile, '/') || str_contains($credentialsFile, 'tmp')) {
             $credentialPath = $credentialsFile; 
        } else {
             $credentialPath = storage_path('app/' . $credentialsFile);
        }

        if (!file_exists($credentialPath)) {
            dd("Error File: File credentials.json tidak ditemukan di " . $credentialPath . ". Cek apakah AppServiceProvider sudah berjalan?");
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
        // 1. Ambil ID Pengunjung (Bungkus try-catch jika Session Driver Database rusak)
        $pengunjungId = null;
        try {
            $pengunjungId = session('current_pengunjung_id');
        } catch (\Throwable $e) {
            // Abaikan error session database
        }

        $pengunjungId = $pengunjungId ?? $request->input('pengunjung_id');
        
        // Fallback ID untuk Vercel jika session gagal/kosong
        if (!$pengunjungId) {
            $pengunjungId = 'Anonim-' . rand(1000, 9999);
        }
        
        // 2. VALIDASI MANUAL
        $validator = Validator::make($request->all(), [
            'usia' => 'required',
            'jenis_kelamin' => 'required',
            'pendidikan_terakhir' => 'required',
            'pekerjaan' => 'required',
            'jenis_layanan_diterima' => 'required',
            'q1_persyaratan' => 'required',
            'q2_prosedur' => 'required',
            'q3_waktu' => 'required',
            'q4_biaya' => 'required',
            'q5_produk' => 'required',
            'q6_kompetensi_petugas' => 'required',
            'q7_perilaku_petugas' => 'required',
            'q8_penanganan_pengaduan' => 'required',
            'q9_sarana' => 'required',
            'saran_masukan' => 'nullable',
        ]);

        if ($validator->fails()) {
            dd("VALIDASI GAGAL! Data tidak lengkap.", $validator->errors()->toArray(), "Data diterima:", $request->all());
        }

        $validated = $validator->validated();

        try {
            // 3. Buat Object Survey (Memory Only)
            $validated['pengunjung_id'] = $pengunjungId;
            $survey = new SurveiKepuasan($validated);

            // --- DATABASE BLOCK (SUPER SAFE MODE) ---
            // Kita bungkus dengan \Throwable agar menangkap Error Fatal sekalipun
            try {
                if (env('APP_ENV') !== 'production') {
                    $pengunjung = Pengunjung::find($pengunjungId);
                    if ($pengunjung) {
                        $survey->save();
                        $pengunjung->update(['sudah_survey' => true]);
                    }
                }
            } catch (\Throwable $dbError) {
                // MASA BODOH dengan error database. Lanjut terus!
            }

            // 4. KIRIM KE GOOGLE SHEETS (Prioritas Utama)
            $this->exportToGoogleSheets($survey);

            // 5. Bersihkan Session (Juga dibungkus jaga-jaga kalau driver session error)
            try {
                session()->forget('current_pengunjung_id');
            } catch (\Throwable $e) {}

            return redirect()->route('survey.thank-you');

        } catch (\Exception $e) {
            // TAMPILKAN ERROR UTAMA (Hanya jika Google Sheets yang gagal)
            dd("GOOGLE SHEETS SYSTEM ERROR: " . $e->getMessage());
        }
    }
    
    /**
     * Ekspor ke Google Sheets
     */
    private function exportToGoogleSheets(SurveiKepuasan $survey)
    {
        $service = $this->getGoogleSheetsService();
        $spreadsheetId = env('GOOGLE_SHEET_ID_SKM', Config::get('app.google_sheet_id_skm'));

        if (empty($spreadsheetId)) {
            dd("Error Config: GOOGLE_SHEET_ID_SKM belum diisi di Vercel.");
        }

        // Susun Data Row
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
            $survey->saran_masukan ?? '-',
        ];
        
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