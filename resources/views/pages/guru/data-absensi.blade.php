@extends('layouts.default-guru')

@section('title')
    Data Absensi - Lab Attendance
@endsection

@section('heading')
    Data Absensi
@endsection

@section('custom-style')
    <!-- Custom styles for this page -->
    <link href="{{ asset('css/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-3">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Filter</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-xl-6 col-lg-6 col-md-6">
                            <h6 class="m-0 mb-3 font-weight-bold text-secondary">UNIT</h6>
                            <button class="btn btn-primary filter-unit mb-1" data-unit="">Semua Unit</button>
                            <button class="btn btn-secondary filter-unit mb-1" data-unit="TK">TK</button>
                            <button class="btn btn-secondary filter-unit mb-1" data-unit="SD">SD</button>
                            <button class="btn btn-secondary filter-unit mb-1" data-unit="SMP">SMP</button>
                            <button class="btn btn-secondary filter-unit mb-1" data-unit="SMK">SMK</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- DataTables Siswa -->
    <div class="card shadow mb-4">

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="siswaTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Unit</th>
                            <th>Nama</th>
                            <th>kehadiran</th>
                            <th>Jam Masuk</th>
                            <th>Jam Pulang</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($students as $item)
                        <tr>
                            <td>{{ $item->unit }}</td>
                            <td>{{ $item->student->name }}</td>
                            <td>{{ $item->status ?? '-'}}</td>
                            <td>{{ $item->check_in_time ?? '-' }}</td>
                            <td>{{ $item->check_out_time ?? '-' }}</td>
                            <td>-</td>
                            <td>
                                <a href="#" class="btn btn-warning btn-icon-split btn-sm" title="Edit">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-pencil"></i>
                                    </span>
                                    {{-- <span class="text">Edit</span> --}}
                                </a>
                                <a class="btn btn-danger btn-icon-split btn-sm" title="Hapus" data-toggle="modal" data-target="#confirmDeleteModal"
                                    data-id='{{ $item->id }}' data-name="{{ $item->name }}" data-url="{{ route('data-siswa.destroy', $item->id) }}">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-trash"></i>
                                    </span>
                                    {{-- <span class="text">Delete</span> --}}
                                </a>
                                {{-- <a href="#" class="btn btn-success btn-icon-split btn-sm" title="unduh QR">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-qrcode"></i>
                                    </span>
                                    <span class="text">unduh QR</span>
                                </a> --}}
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('modal')
@endsection

@section('custom-scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('js/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script>

        // Date
        const now = new Date();
        const date = now.toLocaleDateString('id-ID', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        document.getElementById("heading").textContent = 'Data Absensi ( ' + date + ' )';

        // Call the dataTables jQuery plugin
        $(document).ready(function() {

            // $('#siswaTable').DataTable();
            var table = $('#siswaTable').DataTable();

            var filterUnit = "";

            function applyFilters() {
                table.column(0).search(filterUnit);
                table.draw();
            }

            $('.filter-unit').on('click', function() {
                filterUnit = $(this).data('unit');
                $('.filter-unit').removeClass('btn-primary').addClass('btn-secondary');
                $(this).removeClass('btn-secondary').addClass('btn-primary');
                applyFilters();
            });
        });

    </script>
@endsection
