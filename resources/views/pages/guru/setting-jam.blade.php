@extends('layouts.default-guru')

@section('title')
    Jam Masuk - Lab Attendance
@endsection

@section('heading')
    Pengaturan Jam Masuk
@endsection

@section('custom-style')
    <!-- Custom styles for this page -->
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

        .filepond--credits {
            display: none;
        }
    </style>
@endsection

@section('content')

    <!-- Content Row -->
    <div class="row">

        @foreach ($settings as $item)
        <div class="col-xl-3 col-lg-3">
            <div class="bg-white shadow mb-4 p-3">
                <div class="card-body">

                    <h3>{{ $item->unit }}</h3>

                    <form action="{{ route('setting.attendance-time') }}" method="POST">
                    @csrf
                    <input type="text" name="id" value="{{ $item->id }}" hidden>
                    <div class="row">
                        <div class="col-12 col-lg-12 mb-3">

                            <div class="mb-3 mt-3">
                                <label for="presentTimeInput" class="form-label">Jam Masuk</label>
                                <input type="time" class="form-control" id="presentTimeInput" name="present_time" value="{{ old('present_time', $item->present_time ?? '') }}" autocomplete="off" required="">
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 col-lg-2 mb-3">
                            <button type="submit" class="btn btn-success btn-icon-split btn-md" title="tambah data">
                                <span class="icon text-white-50">
                                    <i class="fas fa-check"></i>
                                </span>
                                <span class="text">simpan</span>
                            </button>
                        </div>
                    </div>
                    </form>

                </div>
            </div>
        </div>
        @endforeach


    </div>

    <script>
        $(document).ready(function () {
            FilePond.registerPlugin(FilePondPluginImagePreview);

            const oldPict = $("#oldPict").attr("data-path");

            let files = oldPict != '0' ? [{source: `${oldPict}`}] : [];
            console.log(oldPict);

            const pond = FilePond.create(document.querySelector('#image-preview'), {
                allowImagePreview : true,
                allowMultiple     : false,
                allowRevert       : true,
                allowRemove       : true,
                storeAsFile       : true,
                files             : files,
            });
        });
    </script>

@endsection

@section('modal')
@endsection

@section('custom-scripts')
    <!-- Page level plugins -->

    <!-- Page level custom scripts -->
@endsection
