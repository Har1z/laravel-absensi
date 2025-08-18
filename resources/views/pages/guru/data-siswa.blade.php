@extends('layouts.default-guru')

@section('title')
    Data Siswa - Lab Attendance
@endsection

@section('heading')
    Data Siswa
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
                            @foreach ($sections as $section)
                                <button class="btn btn-secondary filter-unit mb-1" data-unit="{{ $section->name }}">{{ $section->name }}</button>
                            @endforeach
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
                            <th rowspan="2">Nama</th>
                            <th rowspan="2">Unit</th>
                            <th rowspan="2">Tgl. Lahir</th>
                            <th rowspan="2">L / P</th>
                            <th rowspan="2">Kode Absensi</th>
                            <th colspan="2">No. wali</th>
                            <th rowspan="2">Aksi</th>
                        </tr>
                        <tr>
                            <th>Utama</th>
                            <th>Lainnya</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($students as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->section->name }}</td>
                            <td>{{ $item->formatted_birth }}</td>
                            <td>{{ $item->gender }}</td>
                            <td>{{ $item->identifier ?? '-' }}</td>
                            <td>{{ $item->parent_number }}</td>
                            <td>{{ $item->other_parent_number ? $item->other_parent_number : '-' }}</td>
                            <td>
                                <a href="{{ route('data-siswa.edit', $item->id) }}" class="btn btn-warning btn-icon-split btn-sm" title="Edit">
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
                                <a href="#" class="btn btn-success btn-icon-split btn-sm" title="unduh QR">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-qrcode"></i>
                                    </span>
                                    {{-- <span class="text">unduh QR</span> --}}
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
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm deletion of ()</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih “Hapus” di bawah ini jika Anda benar-benar ingin menghapus data.</div>
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

    {{-- IMPORT DATA MODAL --}}
    @if ($sections->count() > 0)
        <div class="modal" tabindex="-1" id="import-data">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Import Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            @foreach ($sections->toArray() as $item)
                            <div class="col-lg-3">
                                <a class="btn btn-primary import-data-btn w-100" data-unit="{{ $item['name'] }}" data-unit-id="{{ $item['id'] }}">
                                    {{ $item['name'] }}
                                </a>
                            </div>
                            @endforeach
                        </div>
                        <form action="{{ route('import.student') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="my-3 mt-5">
                                <label id="import-label" class="form-label h4">{{ $sections->toArray()[0]['name'] }}</label>
                                <input type="hidden" name="unit" value="{{ $sections->toArray()[0]['id'] }}" id="import-unit">
                                <input type="file" name="file" id="file-preview" class="filepond">
                            </div>
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-success">
                                    Kirim
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('custom-scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('js/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script>

        // Call the dataTables jQuery plugin
        $(document).ready(function() {
            const pond = FilePond.create(document.querySelector('#file-preview'), {
                allowImagePreview : false,
                allowMultiple     : false,
                allowRevert       : true,
                allowRemove       : true,
                storeAsFile       : true,
            });

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

            var table = $('#siswaTable').DataTable();

            // Inject tombol ke depan select entries
            $('#siswaTable_length').prepend(
                "<a href='{{ route('data-siswa.create') }}' class='btn btn-success btn-icon-split btn-sm mr-2 mb-2' title='Tambah data siswa'><span class='icon text-white-50'><i class='fas fa-user-plus'></i></span><span class='text'>Tambah data</span></a>"
            );
            $('#siswaTable_length').prepend(
                "<a data-toggle='modal' data-target='#import-data' class='btn btn-primary btn-icon-split btn-sm mr-2 mb-2' title='Import Data'><span class='icon text-white-50'><i class='fa-solid fa-file-csv'></i></span><span class='text'>Import Data</span></a>"
            );
            $('#siswaTable_length').prepend(
                "<a href='{{ route('import.get-template') }}' class='btn btn-info btn-icon-split btn-sm mr-2 mb-2' title='Template'><span class='icon text-white-50'><i class='fa-solid fa-file-csv'></i></span><span class='text'>Template</span></a>"
            );
            $('#siswaTable_filter').addClass('p-2');
            $('#siswaTable_length').addClass('p-2');


            var filterUnit = "";

            function applyFilters() {
                table.column(1).search(filterUnit);
                table.draw();
            }

            $('.filter-unit').on('click', function() {
                filterUnit = $(this).data('unit');
                $('.filter-unit').removeClass('btn-primary').addClass('btn-secondary');
                $(this).removeClass('btn-secondary').addClass('btn-primary');
                applyFilters();
            });

            $(".import-data-btn").on("click", function() {
                let currentBtn = $(this);

                $("#import-unit").val(currentBtn.attr("data-unit-id"));
                $("#import-label").text(currentBtn.attr("data-unit"));
            });

        });

    </script>
@endsection
