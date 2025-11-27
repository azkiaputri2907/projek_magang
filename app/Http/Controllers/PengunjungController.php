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
        
        // ID Spreadsheet Anda
        $spreadsheetId = env('GOOGLE_SHEET_ID_TAMU', Config::get('app.google_sheet_id_tamu'));
        // PERBAIKAN: Ambil range A:G untuk mendapatkan Waktu Input (index 6) sebagai tanggal acuan.
        $range = 'BukuTamu!A:G'; 

        $pengunjung = collect([]); // Default kosong

        try {
            $service = $this->getGoogleSheetsService();
            $response = $service->spreadsheets_values->get($spreadsheetId, $range);
            $values = $response->getValues();

            if (!empty($values)) {
                // Hapus Header (baris pertama) jika ada teks 'Tanggal'
                if (isset($values[0][0]) && $values[0][0] == 'Tanggal') {
                    array_shift($values);
                }

                // Balik urutan array agar yang paling baru (bawah) jadi paling atas
                $values = array_reverse($values);

                // Mapping array Google Sheets ke Collection Laravel agar mudah di View
                // Urutan Index: 0=Tanggal Form, 1=Nama, 2=Instansi, 3=Layanan, 4=Keperluan, 5=NoHP, 6=Waktu Input
                foreach ($values as $row) {
                    // --- PERBAIKAN LOGIKA TANGGAL ---
                    // Prioritaskan Kolom G ($row[6]) sebagai tanggal/timestamp yang valid
                    $rowDateRaw = $row[6] ?? ($row[0] ?? null);
                    $rowDate = null;
                    
                    try {
                        if ($rowDateRaw) {
                            $rowDate = Carbon::parse($rowDateRaw);
                        }
                    } catch (\Exception $e) {
                        // Jika parsing gagal (misal: serial number Excel), biarkan null
                        $rowDate = null;
                    }

                    // Filter: hanya ambil bulan ini (Opsional)
                    if($rowDate && $rowDate->month == $currentDate->month && $rowDate->year == $currentDate->year) {
                        $pengunjung->push([
                            // Gunakan tanggal yang sudah di-parse dan di-format (YYYY-MM-DD) atau data mentah kolom A jika Kolom G tidak ada/gagal
                        'tanggal' => $row[6] ?? '-',
                        'nama_nip' => $row[1] ?? '-',
                        'instansi' => $row[2] ?? '-',
                        'layanan' => $row[3] ?? '-',
                        'keperluan' => $row[4] ?? '-',
                        ]);
                    }
                }
            }

        } catch (\Exception $e) {
            // Jika gagal koneksi ke Google, biarkan kosong
            // \Log::error("Google Sheets Error: " . $e->getMessage());
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
        
        $credentialsFile = env('GOOGLE_SERVICE_ACCOUNT_CREDENTIALS', Config::get('app.google_service_account_credentials'));

        if (empty($credentialsFile)) {
            throw new \Exception("GOOGLE_SERVICE_ACCOUNT_CREDENTIALS tidak terdefinisi.");
        }
        
        // --- PERBAIKAN PATH CREDENTIALS ---
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
     * Menyimpan data buku tamu ke Google Sheets.
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
            // Buat objek Pengunjung di Memory
            $pengunjung = new Pengunjung($validated);

            // Cek Environment (simpan DB hanya di localhost)
            if (env('APP_ENV') === 'production') {
                $pengunjung->id = rand(10000, 99999); 
            } else {
                $pengunjung->save();
            }
            
            // Kirim Data ke Google Sheets
            $this->exportToGoogleSheets($pengunjung);
            
            session(['current_pengunjung_id' => $pengunjung->id]);
            
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

        // Data yang akan ditambahkan ke baris baru (Kolom A - H Sheet)
        $rowData = [
            $pengunjung->tanggal,
            $pengunjung->nama_nip,
            $pengunjung->instansi,
            $pengunjung->layanan,
            $pengunjung->keperluan,
            $pengunjung->no_hp,
            now()->toDateTimeString() // Kolom H (Waktu Input/created_at)
        ];
        
        $range = 'BukuTamu'; 
        $body = new \Google\Service\Sheets\ValueRange(['values' => [$rowData]]);
        
        $service->spreadsheets_values->append(
            $spreadsheetId,
            $range,
            $body,
            ['valueInputOption' => 'USER_ENTERED', 'insertDataOption' => 'INSERT_ROWS']
        );
    }
}