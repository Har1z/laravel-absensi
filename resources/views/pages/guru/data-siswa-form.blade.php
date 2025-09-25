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

        .filepond--credits {
            display: none;
        }
    </style>
@endsection

@section('content')

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="bg-white shadow mb-4 p-3">
                {{-- <div class="card-body"> --}}

                    <form action="{{ isset($student) ? route('data-siswa.update', $student) : route('data-siswa.store') }}" method="POST" enctype="multipart/form-data">
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

                            <div class="mb-3">
                                <div class="container-fluid p-0">
                                    <div class="row">

                                        @php
                                            $gender = old('gender', $student->gender ?? '');
                                            $unit = old('unit', $student->section_id ?? '');
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
                                            <select class="form-select" id="unitInput" name="section_id">
                                                @foreach ($sections as $section)
                                                    <option value="{{ $section['id'] }}" {{ $unit == $section['id'] ? 'selected' : '' }}>{{ $section['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-12 col-lg-4 mb-3">

                            <div class="mb-3 mt-3">
                                <label for="parentNumberInput" class="form-label">No. wali murid</label>
                                <input type="text" class="form-control" id="parentNumberInput" name="parent_number" value="{{ old('parent_number', $student->parent_number ?? '') }}" autocomplete="off" required="">
                            </div>

                            <div class="mb-3 mt-3">
                                <label for="otherParentNumberInput" class="form-label">No. wali murid lainnya (opsional)</label>
                                <input type="text" class="form-control" id="otherParentNumberInput" name="other_parent_number" value="{{ old('other_parent_number', $student->other_parent_number ?? '') }}" autocomplete="off">
                            </div>

                            <div class="mb-3">
                                <div class="container-fluid p-0">
                                    <div class="row">

                                        @php
                                            $grade = old('grade', $student->grade ?? '');
                                            $major = old('major', $student->major ?? '');
                                        @endphp
                                        <div class="col-5">
                                            <label for="gradeInput" class="form-label">Kelas</label>
                                            <select class="form-select" id="gradeInput" name="grade" required>
                                                <option value="A" {{ $grade == 'A' ? 'selected' : '' }}>A</option>
                                                <option value="B" {{ $grade == 'B' ? 'selected' : '' }}>B</option>
                                                <option value="1" {{ $grade == '1' ? 'selected' : '' }}>1</option>
                                                <option value="2" {{ $grade == '2' ? 'selected' : '' }}>2</option>
                                                <option value="3" {{ $grade == '3' ? 'selected' : '' }}>3</option>
                                                <option value="4" {{ $grade == '4' ? 'selected' : '' }}>4</option>
                                                <option value="5" {{ $grade == '5' ? 'selected' : '' }}>5</option>
                                                <option value="6" {{ $grade == '6' ? 'selected' : '' }}>6</option>
                                                <option value="7" {{ $grade == '7' ? 'selected' : '' }}>7</option>
                                                <option value="8" {{ $grade == '8' ? 'selected' : '' }}>8</option>
                                                <option value="9" {{ $grade == '9' ? 'selected' : '' }}>9</option>
                                                <option value="10" {{ $grade == '10' ? 'selected' : '' }}>10</option>
                                                <option value="11" {{ $grade == '11' ? 'selected' : '' }}>11</option>
                                                <option value="12" {{ $grade == '12' ? 'selected' : '' }}>12</option>
                                            </select>
                                        </div>

                                        <div class="col-7">
                                            <label for="majorInput" class="form-label">Jurusan</label>
                                            <select class="form-select" id="majorInput" name="major">
                                                <option value="" {{ $major == "0" ? 'selected' : '' }}>-- Pilih Jurusan --</option>
                                                <option value="KEC" {{ $major == "KEC" ? 'selected' : '' }}>Kecantikan</option>
                                                <option value="KPR" {{ $major == "KPR" ? 'selected' : '' }}>Keperawatan</option>
                                                <option value="TKJ" {{ $major == "TKJ" ? 'selected' : '' }}>Teknik Komputer & Jaringan</option>
                                                <option value="RPL" {{ $major == "RPL" ? 'selected' : '' }}>Rekayasa Perangkat Lunak</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-4 mb-3">
                            <div class="mt-3">
                                <label for="" class="form-label">Kode Absen (Opsional)</label>
                                <input type="text" class="form-control" name="identifier" value="{{ old('identifier', $student->identifier ?? '') }}">
                            </div>
                            <div class="mt-3">
                                <label for="" class="form-label">Foto Murid</label>
                                <input type="file" class="filepond" id="image-preview" name="file">
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

                {{-- </div> --}}
            </div>
        </div>
        <span id="oldPict" data-path="{{ $studentPict ?? '0' }}"></span>

        @if ($errors->first())
            <ol>
                @foreach ($errors->all() as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ol>
        @endif
    </div>

@endsection

@section('modal')
@endsection

@section('custom-scripts')
    <!-- Page level plugins -->

    <!-- Page level custom scripts -->
    <script>
        const gradeOptions = {
            1: ["A", "B"],              // TK
            2: ["1", "2", "3", "4", "5", "6"], // SD
            3: ["7", "8", "9"],         // SMP
            4: ["10", "11", "12"]       // SMK
        };

        const unitSelect = document.getElementById('unitInput');
        const gradeSelect = document.getElementById('gradeInput');
        const majorSelect = document.getElementById('majorInput');

        function populateGrades(unit, selectedGrade = null) {
            gradeSelect.innerHTML = '<option value="">-- Pilih Kelas --</option>';

            if (unit && gradeOptions[unit]) {
                gradeOptions[unit].forEach(function (grade) {
                    const option = document.createElement('option');
                    option.value = grade;
                    option.textContent = grade;
                    if (selectedGrade && selectedGrade == grade) {
                        option.selected = true;
                    }
                    gradeSelect.appendChild(option);
                });
            }

            if (unit == "4") {
                majorSelect.removeAttribute('disabled');
            } else {
                majorSelect.setAttribute('disabled', 'disabled');
            }
        }
        populateGrades(1);

        // when selected item at #unitInput changed
        unitSelect.addEventListener('change', function () {
            populateGrades(this.value);
        });

        // when there's old value from the server (when editing)
        const oldUnit = "{{ $unit ?? '' }}";
        const oldGrade = "{{ $grade ?? '' }}";
        if (oldUnit) {
            populateGrades(oldUnit, oldGrade);
        }


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
