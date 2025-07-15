@extends('layouts.default-guru')

@section('title')
    Dashboard - Lab Attendance
@endsection

@section('heading')
    Dashboard
@endsection

@section('content')
    <div class="row">
        <!-- Total Siswa Card -->
        <div class="col-xl-3 col-md-6 mb-4" style="user-select: none;">
            <a href="{{ route('data-siswa.index') }}" style="text-decoration: none;">
                <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Siswa</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $studentCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-group fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
            </a>
        </div>

        <!-- Absensi hari ini Card -->
        <div class="col-xl-3 col-md-6 mb-4" style="user-select: none;">
            <a href="{{ route('data-absensi.index') }}" style="text-decoration: none;">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Absensi Hari ini</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $attendanceCount }} / {{ $studentCount }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-check fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- scan QR Card -->
        <div class="col-xl-3 col-md-6 mb-4" style="user-select: none;">
            <a href="{{ route('absensi') }}" style="text-decoration: none;">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Scan QR</div>
                                <div class="h7 mb-0 font-weight-bold text-gray-800">Absen datang / pulang</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-qrcode fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- pengaturan pesan Card -->
        {{-- <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Kelola pesan</div>
                            <div class="h7 mb-0 font-weight-bold text-gray-800">Atur text yang dikirim</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

    </div>
@endsection

@section('modal')

@endsection
