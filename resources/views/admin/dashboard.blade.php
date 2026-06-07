@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<!-- STATISTIK -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-number">{{ $totalGaleri ?? 0 }}</div>
        <div class="stat-label">Galeri</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">{{ $totalBerita ?? 0 }}</div>
        <div class="stat-label">Berita</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">{{ $totalInformasi ?? 0 }}</div>
        <div class="stat-label">Informasi</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">{{ $totalUmkm ?? 0 }}</div>
        <div class="stat-label">UMKM</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">{{ $totalFasilitas ?? 0 }}</div>
        <div class="stat-label">Fasilitas</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">{{ $totalPenginapan ?? 0 }}</div>
        <div class="stat-label">Penginapan</div>
    </div>
</div>

@endsection 

