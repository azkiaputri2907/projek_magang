<?php

namespace App\Http\Controllers;

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
     * Google Sheets connector
     */
    private function getGoogleSheetsService()
    {
        $client = new Client();

        $credentialsFile = env('GOOGLE_SERVICE_ACCOUNT_CREDENTIALS', Config::get('app.google_service_account_credentials'));

        if (empty($credentialsFile)) {
            dd("Error: GOOGLE_SERVICE_ACCOUNT_CREDENTIALS kosong di Vercel.");
        }
        
        if (str_starts_with($credentialsFile, '/') || str_contains($credentialsFile, 'tmp')) {
            $credentialPath = $credentialsFile; 
        } else {
            $credentialPath = storage_path('app/' . $credentialsFile);
        }

        if (!file_exists($credentialPath)) {
            dd("Error: credentials.json tidak ditemukan di " . $credentialPath);
        }

        $client->setAuthConfig($credentialPath);
        $client->setScopes([Sheets::SPREADSHEETS]);

        return new Sheets($client);
    }


    /**
     * Simpan Survey TANPA DATABASE
     */
    public function store(Request $request)
    {
        // ID Pengunjung versi simple
        $pengunjungId = $request->input('pengunjung_id') ?? 'Anonim-' . rand(1000, 9999);

        // VALIDASI
        $validator = Validator::make($request->all(), [
            'usia'                      => 'required',
            'jenis_kelamin'             => 'required',
            'pendidikan_terakhir'       => 'required',
            'pekerjaan'                 => 'required',
            'jenis_layanan_diterima'    => 'required',
            'q1_persyaratan'            => 'required',
            'q2_prosedur'               => 'required',
            'q3_waktu'                  => 'required',
            'q4_biaya'                  => 'required',
            'q5_produk'                 => 'required',
            'q6_kompetensi_petugas'     => 'required',
            'q7_perilaku_petugas'       => 'required',
            'q8_penanganan_pengaduan'   => 'required',
            'q9_sarana'                 => 'required',
            'saran_masukan'             => 'nullable',
        ]);

        if ($validator->fails()) {
            dd("VALIDASI GAGAL!", $validator->errors()->toArray(), "Data:", $request->all());
        }

        $validated = $validator->validated();
        $validated['pengunjung_id'] = $pengunjungId;

        // Ubah jadi object simple
        $survey = (object) $validated;

        // HANYA GOOGLE SHEETS
        try {
            $this->exportToGoogleSheets($survey);

        } catch (\Exception $e) {
            dd("GOOGLE SHEETS ERROR: " . $e->getMessage());
        }

        return redirect()->route('survey.thank-you');
    }


    /**
     * Kirim Data ke Google Sheets
     */
    private function exportToGoogleSheets($survey)
    {
        $service = $this->getGoogleSheetsService();
        $spreadsheetId = env('GOOGLE_SHEET_ID_SKM', Config::get('app.google_sheet_id_skm'));

        if (empty($spreadsheetId)) {
            dd("Error: GOOGLE_SHEET_ID_SKM belum diisi di Vercel.");
        }

        // urutan disesuaikan sama sheet: A - P
        // A: Timestamp, B: Usia, C: JK, D: Pendidikan, E: Pekerjaan, F: Layanan
        // G-O: Q1-Q9, P: Saran
        $rowData = [
            Carbon::now()->toDateTimeString(),  // A (Kolom Baru: Timestamp)
            $survey->usia,                      // B (Usia bergeser ke kanan)
            $survey->jenis_kelamin,             // C
            $survey->pendidikan_terakhir,       // D
            $survey->pekerjaan,                 // E
            $survey->jenis_layanan_diterima,    // F
            $survey->q1_persyaratan,            // G
            $survey->q2_prosedur,               // H
            $survey->q3_waktu,                  // I
            $survey->q4_biaya,                  // J
            $survey->q5_produk,                 // K
            $survey->q6_kompetensi_petugas,     // L
            $survey->q7_perilaku_petugas,       // M
            $survey->q8_penanganan_pengaduan,   // N
            $survey->q9_sarana,                 // O
            $survey->saran_masukan ?? '-',      // P (Saran/Masukan)
        ];
        
        $body = new ValueRange(['values' => [$rowData]]);

        $service->spreadsheets_values->append(
            $spreadsheetId,
            'DataSKM',
            $body,
            ['valueInputOption' => 'USER_ENTERED', 'insertDataOption' => 'INSERT_ROWS']
        );
    }

}