@extends('layouts.app')

@section('title', 'Edit Data SKM')

@section('content')
<div class="container mt-4">
    <h3>Edit Data SKM</h3>

    <form action="{{ route('admin.skm.update', $skm->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-4">
                <label>Usia</label>
                <input type="number" name="usia" value="{{ $skm->usia }}" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-control" required>
                    <option value="Laki-laki" {{ $skm->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ $skm->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <div class="col-md-4">
                <label>Pendidikan Terakhir</label>
                <input type="text" name="pendidikan_terakhir" value="{{ $skm->pendidikan_terakhir }}" class="form-control">
            </div>
            <div class="col-md-6">
                <label>Pekerjaan</label>
                <input type="text" name="pekerjaan" value="{{ $skm->pekerjaan }}" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label>Jenis Layanan Diterima</label>
                <input type="text" name="jenis_layanan_diterima" value="{{ $skm->jenis_layanan_diterima }}" class="form-control" required>
            </div>
        </div>

        <hr>

        @for ($i = 1; $i <= 9; $i++)
            <div class="mb-3">
                <label>Q{{ $i }}</label>
                <input type="number" name="q{{ $i }}_{{ [
                    1=>'persyaratan',
                    2=>'prosedur',
                    3=>'waktu',
                    4=>'biaya',
                    5=>'produk',
                    6=>'kompetensi_petugas',
                    7=>'perilaku_petugas',
                    8=>'penanganan_pengaduan',
                    9=>'sarana'
                ][$i] }}" value="{{ $skm->{'q'.$i.'_'.[
                    1=>'persyaratan',
                    2=>'prosedur',
                    3=>'waktu',
                    4=>'biaya',
                    5=>'produk',
                    6=>'kompetensi_petugas',
                    7=>'perilaku_petugas',
                    8=>'penanganan_pengaduan',
                    9=>'sarana'
                ][$i]} }}" class="form-control" required>
            </div>
        @endfor

        <div class="mb-3">
            <label>Saran Masukan</label>
            <textarea name="saran_masukan" class="form-control">{{ $skm->saran_masukan }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary mt-2">Simpan Perubahan</button>
    </form>
</div>
@endsection
