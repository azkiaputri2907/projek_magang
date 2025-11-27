<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Client;
use Google\Service\Sheets;
use Illuminate\Support\Facades\Config;

class AdminPengunjungController extends Controller
{
    private $sheetId;
    private $sheetName = 'BukuTamu'; // Pastikan sesuai nama Tab di Google Sheet

    public function __construct()
    {
        // Ambil ID dari Config atau ENV
        $this->sheetId = Config::get('app.google_sheet_id_tamu', env('GOOGLE_SHEET_ID_TAMU'));
    }

    // ==========================================
    // READ (INDEX) - TAMPILKAN SEMUA DATA
    // ==========================================
    public function index()
    {
        try {
            $service = $this->getGoogleSheetsService();
            // Ambil data dari baris ke-2 (asumsi baris 1 header) sampai kolom G
            $range = $this->sheetName . '!A2:G'; 
            $response = $service->spreadsheets_values->get($this->sheetId, $range);
            $rows = $response->getValues();

            $data = [];
            if (!empty($rows)) {
                foreach ($rows as $index => $row) {
                    // ID = Index Array + 2 (karena Excel mulai baris 1, dan data mulai baris 2)
                    // ID ini digunakan untuk referensi Hapus/Edit nanti
                    $rowIndex = $index + 2; 

                    $data[] = (object) [
                        'id' => $rowIndex,
                        'tanggal' => $row[6] ?? ($row[0] ?? '-'), // Ambil Waktu Input (index 6 / Kolom G)
                        'nama_nip' => $row[1] ?? '-',
                        'instansi' => $row[2] ?? '-',
                        'layanan' => $row[3] ?? '-',
                        'keperluan' => $row[4] ?? '-',
                        'no_hp' => $row[5] ?? '-',
                        'created_at' => $row[6] ?? '-', // created_at tetap Waktu Input
                    ];
                }
            }

            // Urutkan data terbaru (baris paling bawah di sheet) ke atas
            $data = array_reverse($data);

            // Ubah ke Collection agar mudah dihitung di Blade (tanpa pagination)
            $pengunjung = collect($data);

        } catch (\Exception $e) {
            $pengunjung = collect([]);
            session()->flash('error', 'Gagal koneksi ke Google Sheets: ' . $e->getMessage());
        }

        return view('admin.data_pengunjung', compact('pengunjung'));
    }

    // ==========================================
    // DELETE (BATCH DELETE)
    // ==========================================
    public function batchDelete(Request $request)
    {
        $ids = $request->ids; // Array nomor baris (misal: [5, 3, 10])

        if (!$ids) {
            return back()->with('error', 'Tidak ada data yang dipilih.');
        }

        try {
            $service = $this->getGoogleSheetsService();
            
            // Dapatkan SheetId (GID) numeric
            $sheetIdNumeric = $this->getSheetIdByName($service, $this->sheetName);

            // PENTING: Urutkan ID dari BESAR ke KECIL.
            // Jika hapus baris 3, baris 4 naik jadi 3. Hapus dari bawah aman.
            rsort($ids);

            $requests = [];
            foreach ($ids as $rowIndex) {
                $startIndex = $rowIndex - 1; // API index 0-based

                $requests[] = new \Google\Service\Sheets\Request([
                    'deleteDimension' => [
                        'range' => [
                            'sheetId' => $sheetIdNumeric,
                            'dimension' => 'ROWS',
                            'startIndex' => $startIndex,
                            'endIndex' => $startIndex + 1
                        ]
                    ]
                ]);
            }

            $batchUpdateRequest = new \Google\Service\Sheets\BatchUpdateSpreadsheetRequest([
                'requests' => $requests
            ]);

            $service->spreadsheets->batchUpdate($this->sheetId, $batchUpdateRequest);

            return back()->with('success', 'Data berhasil dihapus dari Google Sheets.');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }

    // ==========================================
    // EDIT (FORM)
    // ==========================================
    public function editMultiple(Request $request)
    {
        $ids = explode(',', $request->ids);
        
        $service = $this->getGoogleSheetsService();
        $items = [];

        // Fetch data spesifik berdasarkan nomor baris untuk diedit
        foreach ($ids as $rowIndex) {
            $range = $this->sheetName . "!A{$rowIndex}:G{$rowIndex}";
            $response = $service->spreadsheets_values->get($this->sheetId, $range);
            $row = $response->getValues()[0] ?? [];

            if (!empty($row)) {
                $items[] = (object) [
                    'id'        => $rowIndex,
                    'tanggal'   => $row[0] ?? '',
                    'nama_nip'  => $row[1] ?? '',
                    'instansi'  => $row[2] ?? '',
                    'layanan'   => $row[3] ?? '',
                    'keperluan' => $row[4] ?? '',
                    'no_hp'     => $row[5] ?? '',
                ];
            }
        }

        return view('admin.edit', compact('items'));
    }

    // ==========================================
    // UPDATE (ACTION)
    // ==========================================
    public function updateMultiple(Request $request)
    {
        $data = $request->input('pengunjung', []);
        
        try {
            $service = $this->getGoogleSheetsService();
            $params = ['valueInputOption' => 'USER_ENTERED'];

            foreach ($data as $rowIndex => $fields) {
                // Construct array sesuai urutan kolom sheet
                $values = [
                    [
                        $fields['tanggal'],
                        $fields['nama_nip'],
                        $fields['instansi'],
                        $fields['layanan'],
                        $fields['keperluan'],
                        $fields['no_hp'],
                        // created_at tidak diubah, jadi tidak dimasukkan ke array update
                    ]
                ];

                // Update range spesifik (Kolom A s/d F)
                $range = $this->sheetName . "!A{$rowIndex}:F{$rowIndex}";
                $body = new \Google\Service\Sheets\ValueRange(['values' => $values]);
                
                $service->spreadsheets_values->update($this->sheetId, $range, $body, $params);
            }

            return redirect()->route('admin.pengunjung')->with('success', 'Data Google Sheets berhasil diperbarui.');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }

    // ==========================================
    // HELPER / SERVICE
    // ==========================================
    private function getGoogleSheetsService()
    {
        $client = new Client();
        
        // Ambil path kredensial dari config (biasanya 'app.google_service_account_credentials')
        $credentialsFile = Config::get('app.google_service_account_credentials');

        // Jika config kosong, ambil dari Env Variable (jika config tidak di-cache)
        if (empty($credentialsFile)) {
            // Asumsi di Vercel, kita mengambil path dari env
            $credentialsFile = env('GOOGLE_SERVICE_ACCOUNT_CREDENTIALS', 'credentials.json');
        }

        $credentialPath = $credentialsFile;

        // **PERBAIKAN BAGIAN 2: Hanya gunakan storage_path() jika path-nya relatif.**
        // Jika $credentialPath dimulai dengan '/', berarti itu adalah path absolut (seperti /tmp/credentials.json)
        // dan tidak perlu digabungkan dengan storage_path().
        if (str_starts_with($credentialPath, '/') === false) {
            $credentialPath = storage_path('app/' . $credentialsFile);
        }
        
        // Cek keberadaan file. Di Vercel, ini akan dicek di /tmp/credentials.json
        if (!file_exists($credentialPath)) {
            // Lakukan pengecekan fallback lain jika perlu
            if(file_exists(base_path($credentialsFile))) {
                $credentialPath = base_path($credentialsFile);
            } else {
                // Ini akan memunculkan error, tetapi sekarang hanya jika semua path gagal
                throw new \Exception("File credential tidak ditemukan pada path: " . $credentialPath);
            }
        }

        $client->setAuthConfig($credentialPath);
        $client->setScopes([Sheets::SPREADSHEETS]);

        return new Sheets($client);
    }

    /**
     * Mendapatkan sheetId (numeric GID) berdasarkan nama sheet/tab.
     */
    private function getSheetIdByName($service, $sheetName)
    {
        $spreadsheet = $service->spreadsheets->get($this->sheetId);
        foreach ($spreadsheet->getSheets() as $sheet) {
            if ($sheet->getProperties()->getTitle() === $sheetName) {
                return $sheet->getProperties()->getSheetId();
            }
        }
        throw new \Exception("Sheet dengan nama '{$sheetName}' tidak ditemukan.");
    }
}