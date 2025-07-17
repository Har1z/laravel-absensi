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
    <style>
        .form-select {
            display: block;
            width: 100%;
            padding: .375rem 1.75rem .375rem .75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #858796;
            vertical-align: middle;
            background-color: #fff;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right .75rem center;
            background-size: 16px 12px;
            border: 1px solid #ced4da;
            border-radius: .25rem;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }
    </style>
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
                                <a class="btn btn-danger btn-icon-split btn-sm" title="Hapus" data-toggle="modal" data-target="#confirmDeleteModal"
                                    data-id='{{ $item->id }}' data-name="{{ $item->student->name }}" data-url="{{ route('data-absensi.destroy', $item->id) }}">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-trash"></i>
                                    </span>
                                    {{-- <span class="text">Delete</span> --}}
                                </a>
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
    <!-- Confirm deletion Modal-->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm deletion.</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih “Hapus” di bawah ini jika Anda benar-benar ingin menghapus data absensi.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <form action="" method="POST" id="deleteForm">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- GET REPORT MODAL --}}
    <div class="modal" tabindex="-1" id="getReportModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Rekap Absen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-3">
                            <a class="btn btn-primary rekap-absen-btn w-100" data-unit="TK">
                                TK
                            </a>
                        </div>
                        <div class="col-lg-3">
                            <a class="btn btn-secondary rekap-absen-btn w-100" data-unit="SD">
                                SD
                            </a>
                        </div>
                        <div class="col-lg-3">
                            <a class="btn btn-secondary rekap-absen-btn w-100" data-unit="SMP">
                                SMP
                            </a>
                        </div>
                        <div class="col-lg-3">
                            <a class="btn btn-secondary rekap-absen-btn w-100" data-unit="SMK">
                                SMK
                            </a>
                        </div>
                    </div>
                    <form action="{{ route('data-absensi.get-report') }}" method="POST">
                        @csrf
                        <div class="my-3 mt-5">
                            <label id="rekap-label" class="form-label h4">TK</label>
                            <br>
                            <input type="hidden" name="unit" value="TK" id="rekap-unit">
                            {{-- <input type="month" name="month" class="form-control" required> --}}
                            <label for="monthInput" class="form-label">Bulan</label>
                            <select name="month" class="form-select mb-3" id="monthInput">
                                @for ($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}">
                                        {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                    </option>
                                @endfor
                            </select>

                            <label for="yearInput" class="form-label">Tahun</label>
                            <select name="year" class="form-select" id="yearInput">
                                @for ($y = 2025; $y <= now()->year; $y++)
                                    <option value="{{ $y }}" {{ $y == now()->year ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-success">
                                Download
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- ABSEN IZIN MODAL --}}
    <div class="modal" tabindex="-1" id="absenIzinModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Absen Siswa Izin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('absen-izin') }}" method="POST">
                        @csrf
                        <div>
                            {{-- <label id="rekap-label" class="form-label h4">TK</label> --}}
                            <br>
                            {{-- <input type="month" name="month" class="form-control" required> --}}
                            <label for="identifierInput" class="form-label">Kode Absensi</label>
                            <input name="identifier" class="form-control mb-3 text-gray-900" id="identifierInput" placeholder="xxxxxxxxx_UNIT_Nama_Siswa" required>

                            <label for="noteInput" class="form-label">Keterangan</label>
                            <input name="note" class="form-control text-gray-900" id="noteInput" placeholder="sakit / izin acara.." required>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-success mt-4">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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

        $('#confirmDeleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // button that triggered the modal
            var url = button.data('url');
            var name = button.data('name');

            // Update modal title
            var modal = $(this);
            modal.find('.modal-title').text('Confirm deletion of (' + name + ')');

            // Update action form
            modal.find('#deleteForm').attr('action', url);
        });

        // Call the dataTables jQuery plugin
        $(document).ready(function() {

            // $('#siswaTable').DataTable();
            var table = $('#siswaTable').DataTable();

            $('#siswaTable_length').prepend(
                "<a data-toggle='modal' data-target='#getReportModal' class='btn btn-primary btn-icon-split btn-sm mr-2 mb-2' title='Rekap Absen'><span class='icon text-white-50'><i class='fa-solid fa-file-csv'></i></span><span class='text'>Rekap Absen</span></a>"
            );
            $('#siswaTable_length').prepend(
                "<a data-toggle='modal' data-target='#absenIzinModal' class='btn btn-info btn-icon-split btn-sm mr-2 mb-2' title='Absen Siswa'><span class='icon text-white-50'><i class='fa-solid fa-school-circle-xmark'></i></span><span class='text'>Absen Izin</span></a>"
            );

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

            $('.rekap-absen-btn').on('click', function() {
                let currentBtn = $(this);

                $("#rekap-unit").val(currentBtn.attr("data-unit"));
                $("#rekap-label").text(currentBtn.attr("data-unit"));
                // filterUnit = $(this).data('unit');
                $('.rekap-absen-btn').removeClass('btn-primary').addClass('btn-secondary');
                $(this).removeClass('btn-secondary').addClass('btn-primary');
                applyFilters();
            });
        });

    </script>
@endsection
