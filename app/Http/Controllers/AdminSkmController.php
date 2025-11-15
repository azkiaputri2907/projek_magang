<?php

namespace App\Http\Controllers;

use App\Models\SurveiKepuasan;
use Google\Client;
use Google\Service\Sheets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class AdminSkmController extends Controller
{
    /* ---------------------------------------------
     * HALAMAN EDIT
     * --------------------------------------------- */
    public function edit($id)
    {
        $skm = SurveiKepuasan::findOrFail($id);
        return view('admin.skm.edit_skm', compact('skm'));
    }

    /* ---------------------------------------------
     * UPDATE DATA SKM + SYNC KE GOOGLE SHEETS
     * --------------------------------------------- */
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
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

            $skm = SurveiKepuasan::findOrFail($id);
            $skm->update($validated);

            // Sync ke Google Sheets
            $this->syncToSheet();

            return Redirect::route('admin.skm')->with("success", "Data SKM berhasil diupdate & disinkronkan.");
        } 
        catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
    }

    /* ---------------------------------------------
     * DELETE + SYNC ULANG
     * --------------------------------------------- */
    public function destroy($id)
    {
        $skm = SurveiKepuasan::findOrFail($id);
        $skm->delete();

        $this->syncToSheet();

        return Redirect::route('admin.skm')->with("success", "Data berhasil dihapus & disinkronkan.");
    }

    /* ---------------------------------------------
     * FUNGSI SYNC KE GOOGLE SHEETS (FINAL VERSION)
     * --------------------------------------------- */
    private function syncToSheet()
    {
        // --- AUTH GOOGLE ---
        $client = new Client();
        $client->setAuthConfig(storage_path('app/credentials.json'));
        $client->addScope(Sheets::SPREADSHEETS);

        $service = new Sheets($client);

        // ID SPREADSHEET
        $spreadsheetId = config('app.google_sheet_id_skm');

        if (!$spreadsheetId) {
            throw new \Exception('google_sheet_id_skm belum diset di config/app.php');
        }

        // --- CLEAR DATA LAMA (A2 ke bawah, biar header aman) ---
        $service->spreadsheets_values->clear(
            $spreadsheetId,
            'DataSKM!A2:Z',
            new \Google\Service\Sheets\ClearValuesRequest()
        );

        // --- AMBIL DATA DARI DB ---
        $data = SurveiKepuasan::all();

        $rows = [];

        foreach ($data as $d) {
            $rows[] = [
                (string)$d->usia,
                $d->jenis_kelamin,
                $d->pendidikan_terakhir,
                $d->pekerjaan,
                $d->jenis_layanan_diterima,
                $d->q1_persyaratan,
                $d->q2_prosedur,
                $d->q3_waktu,
                $d->q4_biaya,
                $d->q5_produk,
                $d->q6_kompetensi_petugas,
                $d->q7_perilaku_petugas,
                $d->q8_penanganan_pengaduan,
                $d->q9_sarana,
                $d->saran_masukan,
                $d->created_at->format('Y-m-d H:i:s'),
            ];
        }

        if (!empty($rows)) {
            $body = new \Google\Service\Sheets\ValueRange([
                'values' => $rows
            ]);

            // --- APPEND (AMAN UNTUK MULTIPLE ROW) ---
            $service->spreadsheets_values->append(
                $spreadsheetId,
                'DataSKM!A2',
                $body,
                ['valueInputOption' => 'USER_ENTERED']
            );
        }
    }
}
