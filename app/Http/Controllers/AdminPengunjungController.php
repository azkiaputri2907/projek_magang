<?php

namespace App\Http\Controllers;

use App\Models\Pengunjung;
use Illuminate\Http\Request;
use Google\Client;
use Google\Service\Sheets;

class AdminPengunjungController extends Controller
{
    public function index()
    {
        $pengunjung = Pengunjung::latest()->get();
        return view('admin.data_pengunjung', compact('pengunjung'));
    }

    public function batchDelete(Request $request)
    {
        $ids = $request->ids;

        if ($ids) {
            Pengunjung::whereIn('id', $ids)->delete();

            // 🔁 Sinkronkan ulang ke Google Sheets
            $this->syncToGoogleSheets();

            return back()->with('success', 'Data berhasil dihapus dan disinkronkan ke Google Sheets.');
        }

        return back()->with('error', 'Tidak ada data yang dipilih.');
    }

    public function editMultiple(Request $request)
    {
        $ids = explode(',', $request->ids);
        $items = Pengunjung::whereIn('id', $ids)->get();
        return view('admin.edit', compact('items'));
    }

    public function updateMultiple(Request $request)
    {
        $data = $request->input('pengunjung', []);

        foreach ($data as $id => $fields) {
            Pengunjung::where('id', $id)->update($fields);
        }

        // 🔁 Sinkronkan ulang ke Google Sheets
        $this->syncToGoogleSheets();

        return redirect()->route('admin.pengunjung')->with('success', 'Data berhasil diperbarui dan disinkronkan ke Google Sheets.');
    }

    // ================= GOOGLE SHEETS ==================

    private function getGoogleSheetsService()
    {
        $client = new Client();

        $credentialPath = storage_path('app/' . env('GOOGLE_SERVICE_ACCOUNT_CREDENTIALS'));

        if (!file_exists($credentialPath)) {
            throw new \Exception("File credentials tidak ditemukan di: " . $credentialPath);
        }

        $client->setAuthConfig($credentialPath);
        $client->setScopes([Sheets::SPREADSHEETS]);

        return new Sheets($client);
    }

    private function syncToGoogleSheets()
    {
        try {
            $service = $this->getGoogleSheetsService();
            $spreadsheetId = env('GOOGLE_SHEET_ID_TAMU');
            $range = 'BukuTamu!A1';

            $pengunjung = Pengunjung::select(
                'tanggal',
                'nama_nip',
                'instansi',
                'layanan',
                'keperluan',
                'no_hp',
                'created_at'
            )->get();

            // Header
            $values = [
                ['Tanggal', 'Nama/NIP', 'Instansi', 'Layanan', 'Keperluan', 'No. HP', 'Waktu Input']
            ];

            foreach ($pengunjung as $item) {
                $values[] = [
                    $item->tanggal,
                    $item->nama_nip,
                    $item->instansi,
                    $item->layanan,
                    $item->keperluan,
                    $item->no_hp,
                    $item->created_at
                ];
            }

            // Kosongkan data lama
            $clearRequest = new \Google\Service\Sheets\ClearValuesRequest();
            $service->spreadsheets_values->clear($spreadsheetId, $range, $clearRequest);

            // Update data baru
            $body = new \Google\Service\Sheets\ValueRange(['values' => $values]);
            $params = ['valueInputOption' => 'USER_ENTERED'];

            $service->spreadsheets_values->update($spreadsheetId, $range, $body, $params);
        } catch (\Throwable $e) {
            // Aman tanpa Log facade, langsung echo ke error log bawaan PHP
            error_log('Gagal sinkron ke Google Sheets: ' . $e->getMessage());
        }
    }
}
