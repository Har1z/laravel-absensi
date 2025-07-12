@extends('layouts.default-guru')

@section('title')
    Data Siswa - Lab Attendance
@endsection

@section('heading')
    {{ Route::current()->getName() == 'data-siswa.edit' ? 'Edit Data' : 'Tambah Data Siswa' }}
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
    </style>
@endsection

@section('content')

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-body">

                    <form action="{{ isset($student) ? route('data-siswa.update', $student) : route('data-siswa.store') }}" method="POST">
                    @csrf
                    @if (isset($student))
                        @method('PUT')
                    @endif
                    <div class="row">
                        <div class="col-12 col-lg-4 mb-3">

                            <div class="mb-3 mt-3">
                                <label for="nameInput" class="form-label">Nama Siswa</label>
                                <input type="text" class="form-control" id="nameInput" name="name" value="{{ old('name', $student->name ?? '') }}" autocomplete="off" required="">
                            </div>

                            <div class="mb-3">
                                <label for="birthInput" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="birthInput" name="birth" value="{{ old('birth', $student->birth ?? '') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="emailInput" class="form-label">Email</label>
                                <input type="email" class="form-control" id="emailInput" name="email" value="{{ old('email', $student->email ?? '') }}" autocomplete="off">
                            </div>

                        </div>

                        <div class="col-12 col-lg-4 mb-3">

                            <div class="mb-3 mt-3">
                                <label for="parentNumberInput" class="form-label">No. wali murid</label>
                                <input type="number" class="form-control" id="parentNumberInput" name="parent_number" value="{{ old('parent_number', $student->parent_number ?? '') }}" autocomplete="off" required="">
                            </div>

                            <div class="mb-3 mt-3">
                                <label for="otherParentNumberInput" class="form-label">No. wali murid lainnya (opsional)</label>
                                <input type="number" class="form-control" id="otherParentNumberInput" name="other_parent_number" value="{{ old('other_parent_numberr', $student->other_parent_numberr ?? '') }}" autocomplete="off">
                            </div>

                            <div class="mb-3">
                                <div class="container-fluid p-0">
                                    <div class="row">

                                        @php
                                            $gender = old('gender', $student->gender ?? '');
                                            $unit = old('unit', $student->unit ?? '');
                                        @endphp
                                        <div class="col-5">
                                            <label for="jenisKelaminInput" class="form-label">Jenis Kelamin</label>
                                            <select class="form-select" id="jenisKelaminInput" name="gender">
                                                <option value="Laki-laki" {{ $gender == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                                <option value="Perempuan" {{ $gender == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                            </select>
                                        </div>

                                        <div class="col-7">
                                            <label for="unitInput" class="form-label">Unit</label>
                                            <select class="form-select" id="unitInput" name="unit">
                                                <option value="TK" {{ $unit == 'TK' ? 'selected' : '' }}>TK</option>
                                                <option value="SD" {{ $unit == 'SD' ? 'selected' : '' }}>SD</option>
                                                <option value="SMP" {{ $unit == 'SMP' ? 'selected' : '' }}>SMP</option>
                                                <option value="SMK" {{ $unit == 'SMK' ? 'selected' : '' }}>SMK</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 col-lg-2   mb-3">
                            <a href="{{ route('data-siswa.index') }}" class="btn btn-secondary btn-icon-split btn-md" title="cancel">
                                <span class="icon text-white-50">
                                    <i class="fas fa-xmark"></i>
                                </span>
                                <span class="text">cancel</span>
                            </a>
                        </div>
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
    </div>

@endsection

@section('modal')
@endsection

@section('custom-scripts')
    <!-- Page level plugins -->

    <!-- Page level custom scripts -->
@endsection
