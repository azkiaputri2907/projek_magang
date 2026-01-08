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
    // LIST DATA RESPONDEN (Index) - Mengambil kolom B sampai F
    // =================================================================
    public function index()
    {
        try {
            $service = $this->getGoogleSheetsService();
            // Ambil data dari baris ke-2 (setelah header) sampai baris terakhir, kolom B sampai F (Usia, JK, Pendidikan, Pekerjaan, Layanan)
            $range = $this->sheetName . '!C2:P';
            $response = $service->spreadsheets_values->get($this->spreadsheetId, $range);
            $values = $response->getValues();

            $skm = [];
            if (!empty($values)) {
                foreach ($values as $index => $row) {
                    // Nomor baris di Sheet = index + 2 (karena dimulai dari baris 2/index 0)
                    $rowIndex = $index + 2;
                    $skm[] = (object) [
                        'id' => $rowIndex, 
                        'usia' => $row[0] ?? '',          // Kolom B (Index 0)
                        'jenis_kelamin' => $row[1] ?? '', // Kolom C (Index 1)
                        'pendidikan_terakhir' => $row[2] ?? '', // Kolom D (Index 2)
                        'pekerjaan' => $row[3] ?? '',          // Kolom E (Index 3)
                        'jenis_layanan_diterima' => $row[4] ?? '', // Kolom F (Index 4)
                    ];
                }
            }

            // DIPERBAIKI: Memanggil view yang sesuai dengan nama file Anda: data_skm_demografi
            return view('admin.skm.data_skm_demografi', compact('skm'));
        } catch (\Exception $e) {
            return view('admin.skm.data_skm_demografi')->with('error', 'Gagal memuat data responden: ' . $e->getMessage());
        }
    }

    // =================================================================
    // LIST DATA JAWABAN (Jawaban) - Mengambil kolom G sampai P
    // =================================================================
    public function jawaban()
    {
        try {
            $service = $this->getGoogleSheetsService();
            // Ambil data dari baris ke-2 (setelah header) sampai baris terakhir, kolom G sampai P (Q1-Q9 dan Saran)
            $range = $this->sheetName . '!G2:P';
            $response = $service->spreadsheets_values->get($this->spreadsheetId, $range);
            $values = $response->getValues();

            $skm = [];
            if (!empty($values)) {
                foreach ($values as $index => $row) {
                    // Nomor baris di Sheet = index + 2
                    $rowIndex = $index + 2;
                    $skm[] = (object) [
                        'id' => $rowIndex, 
                        'q1_persyaratan' => $row[0] ?? '',         // Kolom G (Index 0)
                        'q2_prosedur' => $row[1] ?? '',            // Kolom H (Index 1)
                        'q3_waktu' => $row[2] ?? '',               // Kolom I (Index 2)
                        'q4_biaya' => $row[3] ?? '',               // Kolom J (Index 3)
                        'q5_produk' => $row[4] ?? '',              // Kolom K (Index 4)
                        'q6_kompetensi_petugas' => $row[5] ?? '',  // Kolom L (Index 5)
                        'q7_perilaku_petugas' => $row[6] ?? '',    // Kolom M (Index 6)
                        'q8_penanganan_pengaduan' => $row[7] ?? '', // Kolom N (Index 7)
                        'q9_sarana' => $row[8] ?? '',              // Kolom O (Index 8)
                        'saran_masukan' => $row[9] ?? '',          // Kolom P (Index 9)
                    ];
                }
            }

            // DIPERBAIKI: Memanggil view yang sesuai dengan nama file Anda: data_skm_pertanyaan
            return view('admin.skm.data_skm_pertanyaan', compact('skm'));
        } catch (\Exception $e) {
            // DIPERBAIKI: Memanggil view yang sesuai dengan nama file Anda
            return view('admin.skm.data_skm_pertanyaan')->with('error', 'Gagal memuat data jawaban: ' . $e->getMessage());
        }
    }

    // =================================================================
    // 4. EDIT (AMBIL DATA RESPONDEN B-F)
    // =================================================================
    public function edit($id)
    {
        if ($id < 2) {
            return back()->with('error', 'Tidak dapat mengedit baris header.');
        }

        try {
            $service = $this->getGoogleSheetsService();
            
            // Range dibatasi hanya B sampai F (Data Responden)
            $range = $this->sheetName . "!B{$id}:P{$id}";
            $response = $service->spreadsheets_values->get($this->spreadsheetId, $range);
            $values = $response->getValues();

            if (empty($values)) {
                return back()->with('error', 'Data tidak ditemukan di baris tersebut.');
            }

            $row = $values[0];

            // Mapping berdasarkan range B:F -> index 0-4
            $skm = (object) [
                'id' => $id, 
                // DATA RESPONDEN (Mapping berdasarkan range B:F -> index 0-4)
                'usia' => $row[0] ?? '',                   // Kolom B
                'jenis_kelamin' => $row[1] ?? '',          // Kolom C
                'pendidikan_terakhir' => $row[2] ?? '',    // Kolom D
                'pekerjaan' => $row[3] ?? '',              // Kolom E
                'jenis_layanan_diterima' => $row[4] ?? '', // Kolom F
                // Data Jawaban (Wajib diambil agar form terisi)
                'q1_persyaratan'        => $row[5] ?? '', // G
                'q2_prosedur'           => $row[6] ?? '', // H
                'q3_waktu'              => $row[7] ?? '', // I
                'q4_biaya'              => $row[8] ?? '', // J
                'q5_produk'             => $row[9] ?? '', // K
                'q6_kompetensi_petugas' => $row[10]?? '', // L
                'q7_perilaku_petugas'   => $row[11]?? '', // M
                'q8_penanganan_pengaduan'=> $row[12]?? '',// N
                'q9_sarana'             => $row[13]?? '', // O
                'saran_masukan'         => $row[14]?? '', // P
            ];

            // Anda harus menyediakan view edit_skm.blade.php
            return view('admin.skm.edit_skm', compact('skm')); 

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengambil data dari Google Sheet: ' . $e->getMessage());
        }
    }

    // =================================================================
    // 5. UPDATE (TIMPA DATA RESPONDEN KE SHEET B-F)
    // =================================================================
    public function update(Request $request, $id)
    {
        // Validasi disederhanakan untuk contoh
        $request->validate([
            'usia' => 'required',
            'jenis_kelamin' => 'required|string',
            'pendidikan_terakhir' => 'required|string',
            'pekerjaan' => 'required|string',
            'jenis_layanan_diterima' => 'required|string',

            // Tambahkan Validasi untuk Nilai Survey
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

        try {
            $service = $this->getGoogleSheetsService();

            // Susun data array sesuai urutan Kolom B - F di Google Sheet
            $updateRow = [
                $request->usia,                  // Kolom B
                $request->jenis_kelamin,         // Kolom C
                $request->pendidikan_terakhir,   // Kolom D
                $request->pekerjaan,             // Kolom E
                $request->jenis_layanan_diterima,// Kolom F
                // Tambahan Data Survey (Sebelumnya hilang)
                $request->q1_persyaratan,               // Kolom G
                $request->q2_prosedur,                  // Kolom H
                $request->q3_waktu,                     // Kolom I
                $request->q4_biaya,                     // Kolom J
                $request->q5_produk,                    // Kolom K
                $request->q6_kompetensi_petugas,        // Kolom L
                $request->q7_perilaku_petugas,          // Kolom M
                $request->q8_penanganan_pengaduan,      // Kolom N
                $request->q9_sarana,                    // Kolom O
                $request->saran_masukan ?? '-'          // Kolom P
            ];

            // Tentukan Range: Update baris ke-$id, kolom B sampai F
            $range = $this->sheetName . "!B{$id}:P{$id}";
            
            $body = new \Google\Service\Sheets\ValueRange([
                'values' => [$updateRow]
            ]);
            
            $params = ['valueInputOption' => 'USER_ENTERED'];

            // Eksekusi Update ke Google Sheets
            $service->spreadsheets_values->update($this->spreadsheetId, $range, $body, $params);

            // Redirect ke halaman index SKM
            return Redirect::route('admin.skm')->with("success", "Data SKM responden baris ke-{$id} berhasil diperbarui.");

        } catch (\Exception $e) {
            return back()->with("error", "Gagal Update Google Sheet: " . $e->getMessage())->withInput();
        }
    }
    
    // =================================================================
    // 6. DELETE (HAPUS BARIS DI SHEET - Digunakan untuk Responden & Jawaban)
    // =================================================================
    // Fungsi ini tidak perlu diubah, karena sudah benar menggunakan BatchUpdate untuk menghapus 1 baris penuh.
    public function destroy($id)
    {
        if ($id < 2) {
             return back()->with('error', 'Tidak bisa menghapus header.');
        }

        try {
            $service = $this->getGoogleSheetsService();

            $sheetIdNumeric = $this->getSheetIdByName($service, $this->sheetName);

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
    // HELPER FUNCTIONS (Tidak Diubah)
    // =================================================================

    private function getGoogleSheetsService()
    {
        $client = new Client();
        
        $credentialsFile = Config::get('app.google_service_account_credentials');

        if (empty($credentialsFile)) {
            $credentialsFile = env('GOOGLE_SERVICE_ACCOUNT_CREDENTIALS', 'credentials.json');
        }

        $credentialPath = $credentialsFile;

        if (str_starts_with($credentialPath, '/') === false) {
            $credentialPath = storage_path('app/' . $credentialsFile);
        }
        
        if (!file_exists($credentialPath)) {
            if(file_exists(base_path($credentialsFile))) {
                $credentialPath = base_path($credentialsFile);
            } else {
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