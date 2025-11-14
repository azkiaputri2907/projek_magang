@extends('layouts.app')

@section('title','Edit Banyak Pengunjung')

@section('content')
<div class="container-dashboard">
    <h2>Edit Data Pengunjung</h2>
    <form action="{{ route('pengunjung.updateMultiple') }}" method="POST">
        @csrf
        @foreach($items as $item)
        <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
            <input type="hidden" name="pengunjung[{{ $item->id }}][id]" value="{{ $item->id }}">
            <label>Tanggal: <input type="date" name="pengunjung[{{ $item->id }}][tanggal]" value="{{ $item->tanggal }}"></label><br>
            <label>Nama/NIP: <input type="text" name="pengunjung[{{ $item->id }}][nama_nip]" value="{{ $item->nama_nip }}"></label><br>
            <label>Instansi: <input type="text" name="pengunjung[{{ $item->id }}][instansi]" value="{{ $item->instansi }}"></label><br>
            <label>Layanan: <input type="text" name="pengunjung[{{ $item->id }}][layanan]" value="{{ $item->layanan }}"></label><br>
            <label>Keperluan: <input type="text" name="pengunjung[{{ $item->id }}][keperluan]" value="{{ $item->keperluan }}"></label><br>
            <label>No.Hp: <input type="text" name="pengunjung[{{ $item->id }}][no_hp]" value="{{ $item->no_hp }}"></label>
        </div>
        @endforeach
        <button type="submit" class="btn-action btn-simpan">Simpan Semua</button>
    </form>
</div>
@endsection
@include('components._footer')