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
        
        // Cek Variable Environment di Vercel
        $credentialsFile = env('GOOGLE_SERVICE_ACCOUNT_CREDENTIALS', Config::get('app.google_service_account_credentials'));

        if (empty($credentialsFile)) {
            throw new \Exception("GOOGLE_SERVICE_ACCOUNT_CREDENTIALS belum diatur di Vercel.");
        }
        
        // Logika Path (Support Local & Vercel)
        if (str_starts_with($credentialsFile, '/') || str_contains($credentialsFile, 'tmp')) {
             $credentialPath = $credentialsFile; 
        } else {
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
        try {
            // 1. Ambil ID Pengunjung (Dengan Fallback Aman)
            $pengunjungId = session('current_pengunjung_id') ?? $request->input('pengunjung_id');
            
            // JIKA DI VERCEL & ID HILANG: Jangan Error, tapi pakai 'Anonim'
            if (env('APP_ENV') === 'production' && !$pengunjungId) {
                $pengunjungId = 'Anonim-' . rand(1000, 9999);
            }

            // Jika di Localhost & ID Hilang: Baru boleh error
            if (env('APP_ENV') !== 'production' && !$pengunjungId) {
                return redirect('/')->withErrors('Sesi habis. Silakan isi buku tamu lagi.');
            }
            
            // 2. Validasi Form (Pastikan 'name' di form HTML sesuai ini)
            $validated = $request->validate([
                'usia' => 'required',
                'jenis_kelamin' => 'required',
                'pendidikan_terakhir' => 'required',
                'pekerjaan' => 'required',
                'jenis_layanan_diterima' => 'required',
                // Pertanyaan bisa nullable atau required, sesuaikan kebutuhan
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
            
            // 3. Buat Object Survey (Memory Only)
            $validated['pengunjung_id'] = $pengunjungId;
            $survey = new SurveiKepuasan($validated);

            // Simpan DB hanya jika Localhost
            if (env('APP_ENV') !== 'production') {
                $pengunjung = Pengunjung::find($pengunjungId);
                if ($pengunjung) {
                    $survey->save();
                    $pengunjung->update(['sudah_survey' => true]);
                }
            }

            // 4. KIRIM KE GOOGLE SHEETS (Action Utama)
            $this->exportToGoogleSheets($survey);

            // 5. Sukses
            session()->forget('current_pengunjung_id');
            return redirect()->route('survey.thank-you');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Error Validasi (Form belum lengkap)
            return back()->withInput()->withErrors($e->errors());
        } catch (\Exception $e) {
            // Error Sistem / Google Sheets
            return back()->withInput()->withErrors('Gagal Kirim Survey: ' . $e->getMessage());
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
            throw new \Exception("ID Spreadsheet SKM belum diisi di Vercel (GOOGLE_SHEET_ID_SKM).");
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
        
        // PENTING: Nama Sheet harus 'DataSKM'. 
        // Kalau di excelmu namanya 'Sheet1', error 'Unable to parse range' akan muncul.
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