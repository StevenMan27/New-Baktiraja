@extends('layouts.admin')

@section('title', 'Profil Geosite')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">🏞️ Manajemen Profil Geosite</h5>
</div>

<div class="card">
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Geosite</th>
                    <th>Status Profil</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @foreach($geosites as $slug => $nama)
                @php 
                    $profil = $profiles->get($slug); 
                    $hasProfile = $profil ? true : false;
                @endphp
                <tr>
                    <td>{{ $i++ }}</td>
                    <td><span class="badge bg-info text-dark">{{ $nama }}</span> ({{ $slug }})</td>
                    <td>
                        @if($hasProfile)
                            <span class="badge bg-success">Tersedia</span>
                        @else
                            <span class="badge bg-secondary">Belum Diisi</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.profil.edit', $slug) }}" class="btn-edit">
                                <i class="fas {{ $hasProfile ? 'fa-edit' : 'fa-plus' }}"></i> 
                                {{ $hasProfile ? 'Edit Profil' : 'Buat Profil' }}
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
