<?php

namespace App\Http\Controllers;

use Google\Client;
use Google\Service\Sheets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;

class AdminSkmController extends Controller
{
    private $spreadsheetId;
    private $sheetName = 'DataSKM'; // Pastikan nama Tab di Sheet Anda "DataSKM"

    public function __construct()
    {
        // Ambil ID Spreadsheet dari Config/Env
        $this->spreadsheetId = Config::get('app.google_sheet_id_skm');
    }

    // =================================================================
    // 1. EDIT (AMBIL DATA DARI SHEET BERDASARKAN NOMOR BARIS)
    // =================================================================
    public function edit($id)
    {
        // $id di sini adalah NOMOR BARIS di Excel (misal: 5)
        // Validasi sederhana agar tidak mengedit Header (baris 1)
        if ($id < 2) {
            return back()->with('error', 'Tidak dapat mengedit baris header.');
        }

        try {
            $service = $this->getGoogleSheetsService();
            
            // Ambil data dari baris tersebut (Kolom A sampai O)
            // Asumsi Kolom:
            // A=Usia, B=JK, C=Pendidikan, D=Pekerjaan, E=Layanan
            // F-N = Q1-Q9, O=Saran
            $range = $this->sheetName . "!A{$id}:O{$id}";
            $response = $service->spreadsheets_values->get($this->spreadsheetId, $range);
            $values = $response->getValues();

            if (empty($values)) {
                return back()->with('error', 'Data tidak ditemukan di baris tersebut.');
            }

            $row = $values[0];

            // Mapping Array Sheet ke Object (agar View Blade tidak error saat panggil $skm->usia)
            $skm = (object) [
                'id'                      => $id, // ID sekarang adalah nomor baris
                
                // DATA SURVEY (Bergeser 1 kolom ke kanan)
                'usia'                    => $row[1] ?? '', // Kolom B
                'jenis_kelamin'           => $row[2] ?? '', // Kolom C
                'pendidikan_terakhir'     => $row[3] ?? '', // Kolom D
                'pekerjaan'               => $row[4] ?? '', // Kolom E
                'jenis_layanan_diterima'  => $row[5] ?? '', // Kolom F
                
                // Nilai Survey (Q1-Q9) - Mulai dari index 6
                'q1_persyaratan'          => $row[6] ?? '', // Kolom G
                'q2_prosedur'             => $row[7] ?? '', // Kolom H
                'q3_waktu'                => $row[8] ?? '', // Kolom I
                'q4_biaya'                => $row[9] ?? '', // Kolom J
                'q5_produk'               => $row[10] ?? '', // Kolom K
                'q6_kompetensi_petugas'   => $row[11] ?? '', // Kolom L
                'q7_perilaku_petugas'     => $row[12] ?? '', // Kolom M
                'q8_penanganan_pengaduan' => $row[13] ?? '', // Kolom N
                'q9_sarana'               => $row[14] ?? '', // Kolom O
                
                'saran_masukan'           => $row[15] ?? '', // Kolom P
            ];

            return view('admin.skm.edit_skm', compact('skm'));

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengambil data dari Google Sheet: ' . $e->getMessage());
        }
    }

    // =================================================================
    // 2. UPDATE (TIMPA DATA KE SHEET)
    // =================================================================
    public function update(Request $request, $id)
    {
        // Validasi Input
        $request->validate([
            'usia' => 'required|integer',
            'jenis_kelamin' => 'required|string',
            'pendidikan_terakhir' => 'required|string',
            'pekerjaan' => 'required|string',
            'jenis_layanan_diterima' => 'required|string',
            'q1_persyaratan' => 'required|integer|min:1|max:4',
            'q2_prosedur' => 'required|integer|min:1|max:4',
            'q3_waktu' => 'required|integer|min:1|max:4',
            'q4_biaya' => 'required|integer|min:1|max:4',
            'q5_produk' => 'required|integer|min:1|max:4',
            'q6_kompetensi_petugas' => 'required|integer|min:1|max:4',
            'q7_perilaku_petugas' => 'required|integer|min:1|max:4',
            'q8_penanganan_pengaduan' => 'required|integer|min:1|max:4',
            'q9_sarana' => 'required|integer|min:1|max:4',
            'saran_masukan' => 'nullable|string',
        ]);

        try {
            $service = $this->getGoogleSheetsService();

            // Susun data array sesuai urutan Kolom A - O 
            // Kita TIDAK mengupdate kolom P (Timestamp) agar data waktu asli terjaga
            $updateRow = [
                $request->usia,
                $request->jenis_kelamin,
                $request->pendidikan_terakhir,
                $request->pekerjaan,
                $request->jenis_layanan_diterima,
                $request->q1_persyaratan,
                $request->q2_prosedur,
                $request->q3_waktu,
                $request->q4_biaya,
                $request->q5_produk,
                $request->q6_kompetensi_petugas,
                $request->q7_perilaku_petugas,
                $request->q8_penanganan_pengaduan,
                $request->q9_sarana,
                $request->saran_masukan ?? ''
            ];

            // Tentukan Range: Update baris ke-$id, kolom A sampai O
            $range = $this->sheetName . "!A{$id}:O{$id}";
            
            $body = new \Google\Service\Sheets\ValueRange([
                'values' => [$updateRow]
            ]);
            
            $params = ['valueInputOption' => 'USER_ENTERED'];

            // Eksekusi Update ke Google Sheets
            $service->spreadsheets_values->update($this->spreadsheetId, $range, $body, $params);

            // Redirect ke halaman index SKM
            return Redirect::route('admin.skm')->with("success", "Data SKM baris ke-{$id} berhasil diperbarui di Google Sheets.");

        } catch (\Exception $e) {
            return back()->with("error", "Gagal Update Google Sheet: " . $e->getMessage())->withInput();
        }
    }

    // =================================================================
    // 3. DELETE (HAPUS BARIS DI SHEET)
    // =================================================================
    public function destroy($id)
    {
        if ($id < 2) {
             return back()->with('error', 'Tidak bisa menghapus header.');
        }

        try {
            $service = $this->getGoogleSheetsService();

            // Kita butuh Sheet ID (angka/GID), bukan cuma nama tab string.
            $sheetIdNumeric = $this->getSheetIdByName($service, $this->sheetName);

            // Google Sheets API index mulai dari 0.
            // Baris 1 Excel = Index 0.
            // Baris $id Excel = Index $id - 1.
            $startIndex = $id - 1; 

            $requestBody = new \Google\Service\Sheets\BatchUpdateSpreadsheetRequest([
                'requests' => [
                    [
                        'deleteDimension' => [
                            'range' => [
                                'sheetId' => $sheetIdNumeric,
                                'dimension' => 'ROWS',
                                'startIndex' => $startIndex,
                                'endIndex' => $startIndex + 1 // Hapus 1 baris
                            ]
                        ]
                    ]
                ]
            ]);

            $service->spreadsheets->batchUpdate($this->spreadsheetId, $requestBody);

            return Redirect::back()->with("success", "Data baris ke-{$id} berhasil dihapus dari Google Sheets.");

        } catch (\Exception $e) {
            return back()->with("error", "Gagal Hapus dari Google Sheet: " . $e->getMessage());
        }
    }

    // =================================================================
    // HELPER FUNCTIONS
    // =================================================================

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

    private function getSheetIdByName($service, $sheetName)
    {
        $spreadsheet = $service->spreadsheets->get($this->spreadsheetId);
        foreach ($spreadsheet->getSheets() as $sheet) {
            if ($sheet->getProperties()->getTitle() === $sheetName) {
                return $sheet->getProperties()->getSheetId();
            }
        }
        return 0; 
    }
}