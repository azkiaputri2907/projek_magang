<?php

namespace App\Http\Controllers;

use App\Models\Pengunjung;
use App\Models\SurveiKepuasan;
use Google\Client;
use Google\Service\Sheets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class AdminController extends Controller
{
    // ============================
    // AUTH
    // ============================

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
    

    // ============================
    // DASHBOARD
    // ============================

    public function dashboard() 
    { 
        return view('admin.dashboard_admin', [
            'total_pengunjung' => Pengunjung::count(),
            'total_skm' => SurveiKepuasan::count()
        ]);
    }


    // ============================
    // DATA VIEW
    // ============================

    public function dataPengunjung() 
    { 
        $pengunjung = Pengunjung::latest()->paginate(10);
        return view('admin.data_pengunjung', compact('pengunjung')); 
    }
    
    public function dataSkmDemografi() 
    { 
        $skm = SurveiKepuasan::with('pengunjung')->latest()->paginate(10);
        return view('admin.skm.data_skm_demografi', compact('skm')); 
    }
    
    public function dataSkmPertanyaan() 
    { 
        $skm = SurveiKepuasan::latest()->paginate(10);
        return view('admin.skm.data_skm_pertanyaan', compact('skm')); 
    }


    // ============================
    // LAPORAN
    // ============================

    public function laporan() 
    { 
        // ============================
        // UPDATED SECTION (untuk grafik laporan)
        // ============================

        $totalPengunjung = Pengunjung::count();
        $totalSkm = SurveiKepuasan::count();

        $dataGender = SurveiKepuasan::selectRaw('jenis_kelamin, COUNT(*) as total')
            ->groupBy('jenis_kelamin')
            ->pluck('total', 'jenis_kelamin');

        $dataLayanan = SurveiKepuasan::selectRaw('jenis_layanan_diterima, COUNT(*) as total')
            ->groupBy('jenis_layanan_diterima')
            ->pluck('total', 'jenis_layanan_diterima');

        $dataPendidikan = SurveiKepuasan::selectRaw('pendidikan_terakhir, COUNT(*) as total')
            ->groupBy('pendidikan_terakhir')
            ->pluck('total', 'pendidikan_terakhir');

        return view('admin.laporan', compact(
            'totalPengunjung',
            'totalSkm',
            'dataGender',
            'dataLayanan',
            'dataPendidikan'
        ));
    }


    // ============================
    // GOOGLE SHEETS
    // ============================

    private function getGoogleSheetsService()
    {
        $client = new Client();

        // ============================
        // UPDATED SECTION (fix path credential)
        // ============================
        $credentialsFile = Config::get('app.google_service_account_credentials');

        if (empty($credentialsFile)) {
            throw new \Exception("GOOGLE_SERVICE_ACCOUNT_CREDENTIALS tidak ditemukan di config.");
        }

        $credentialPath = storage_path('app/' . $credentialsFile);

        if (!file_exists($credentialPath)) {
            throw new \Exception("File credential tidak ditemukan di: " . $credentialPath);
        }

        $client->setAuthConfig($credentialPath);
        $client->setScopes([Sheets::SPREADSHEETS]);

        return new Sheets($client);
    }


    public function downloadPengunjung()
    {
        try {
            $service = $this->getGoogleSheetsService();
            $spreadsheetId = Config::get('app.google_sheet_id_tamu');

            if (empty($spreadsheetId)) {
                throw new \Exception("GOOGLE_SHEET_ID_TAMU tidak ditemukan di config.");
            }

            // ============================
            // UPDATED SECTION (header + mulai A1)
            // ============================

            $data = Pengunjung::select('tanggal', 'nama_nip', 'instansi', 'layanan', 'keperluan', 'no_hp', 'created_at')
                ->get()
                ->toArray();

            $header = ['Tanggal', 'Nama/NIP', 'Instansi', 'Layanan', 'Keperluan', 'No HP', 'Waktu Input'];
            array_unshift($data, $header);

            $body = new \Google\Service\Sheets\ValueRange(['values' => $data]);

            $service->spreadsheets_values->update(
                $spreadsheetId,
                'BukuTamu!A1',
                $body,
                ['valueInputOption' => 'USER_ENTERED']
            );

            $sheetUrl = 'https://docs.google.com/spreadsheets/d/' . $spreadsheetId;

            return redirect()->route('admin.laporan')
                ->with('success', "Data Pengunjung berhasil diupdate! <a href='{$sheetUrl}' target='_blank'>Klik untuk unduh</a>");

        } catch (\Exception $e) {
            return redirect()->route('admin.laporan')
                ->with('error', "Gagal update Pengunjung: " . $e->getMessage());
        }
    }


    public function downloadSkm()
    {
        try {
            $service = $this->getGoogleSheetsService();
            $spreadsheetId = Config::get('app.google_sheet_id_skm');

            if (empty($spreadsheetId)) {
                throw new \Exception("GOOGLE_SHEET_ID_SKM tidak ditemukan di config.");
            }

            // ============================
            // UPDATED SECTION (header + mulai A1)
            // ============================

            $data = SurveiKepuasan::select([
                'usia', 'jenis_kelamin', 'pendidikan_terakhir', 'pekerjaan', 'jenis_layanan_diterima',
                'q1_persyaratan', 'q2_prosedur', 'q3_waktu', 'q4_biaya', 'q5_produk',
                'q6_kompetensi_petugas', 'q7_perilaku_petugas', 'q8_penanganan_pengaduan', 'q9_sarana',
                'saran_masukan', 'created_at'
            ])->get()->toArray();

            $header = [
                'Usia', 'Jenis Kelamin', 'Pendidikan', 'Pekerjaan', 'Layanan',
                'Q1', 'Q2', 'Q3', 'Q4', 'Q5', 'Q6', 'Q7', 'Q8', 'Q9',
                'Saran', 'Waktu Input'
            ];

            array_unshift($data, $header);

            $body = new \Google\Service\Sheets\ValueRange(['values' => $data]);

            $service->spreadsheets_values->update(
                $spreadsheetId,
                'DataSKM!A1',
                $body,
                ['valueInputOption' => 'USER_ENTERED']
            );

            $sheetUrl = 'https://docs.google.com/spreadsheets/d/' . $spreadsheetId;

            return redirect()->route('admin.laporan')
                ->with('success', "Data SKM berhasil diupdate! <a href='{$sheetUrl}' target='_blank'>Klik untuk unduh</a>");

        } catch (\Exception $e) {
            return redirect()->route('admin.laporan')
                ->with('error', "Gagal update SKM: " . $e->getMessage());
        }
    }

}
