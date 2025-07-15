@extends('layouts.default-guru')

@section('title')
    Kelola Pesan - Lab Attendance
@endsection

@section('heading')
    Pengaturan Pesan Whatsapp
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

        .chat-bubble {
            background-color: #333;
            color: white;
            border-radius: 15px;
            padding: 10px 15px;
            display: inline-block;
            position: relative;
            max-width: 70%;
        }

        .chat-bubble::after {
            content: '';
            position: absolute;
            top: 0;
            right: 10px;
            border-width: 10px;
            border-style: solid;
            border-color: #333 transparent transparent transparent;
        }

        .chat-time {
            display: block;
            font-size: 0.8em;
            color: #b0b0b0;
            text-align: right;
        }

        .chat-container {
            margin: 20px;
        }
    </style>
@endsection

@section('content')

    <!-- Unit Row -->
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-3">
                <!-- Card Body -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-xl-6 col-lg-6 col-md-6" aria-label="Unit Selector">
                            <h6 class="m-0 mb-3 font-weight-bold text-secondary">UNIT</h6>
                            @foreach ($data as $unit => $setting)
                                <button type="button" class="btn btn-secondary btn-unit" data-unit="{{ $unit }}">{{ $unit }}</button>
                            @endforeach
                        </div>
                        <div class="col-12 col-xl-6 col-lg-6 col-md-6">
                            <h5 class=""><b>NOTE</b></h5>
                            <ul class="pl-3">
                                <li>Gunakan "{nama}" untuk menambah nama siswa pada pesan WhatsApp</li>
                                <li>Nama siswa yang tertulis pada tampilan hanya sebagai contoh</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="bg-white shadow mb-4 p-3">

                <form action="{{ route('update.attendance-message') }}" method="POST">
                <input type="hidden" name="id" id="formId" value="">
                @csrf
                <div class="row">

                    <div class="col-12 col-lg-5 mb-3">
                        <label for="inputHadir" class="form-label mt-1"><b>Pesan Absen Masuk</b></label>
                        <textarea name="in_message" class="form-control mb-2" id="inputHadir"></textarea>

                        <div class="preview-chat mb-1 mt-3">
                            <div class="chat-bubble">
                                <p class="fs-6" id="pesan-masuk"></p>
                                <span class="chat-time">05.23</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-1"></div>

                    <div class="col-12 col-lg-5 mb-3">
                        <label for="inputPulang" class="form-label mt-1"><b>Pesan Absen Pulang</b></label>
                        <textarea name="out_message" class="form-control mb-2" id="inputPulang"></textarea>

                        <div class="preview-chat mb-1 mt-3">
                            <div class="chat-bubble">
                                <p class="fs-6" id="pesan-pulang"></p>
                                <span class="chat-time">07.13</span>
                            </div>
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
@endsection

@section('modal')
@endsection

@section('custom-scripts')
    <!-- Page level plugins -->

    <!-- Page level custom scripts -->
    <script>
        const data = @json($data);

        // button & unit data
        $(document).ready(function() {
            $('.btn-unit').on('click', function() {
                const unit = $(this).data('unit');
                const setting = data[unit];

                $('#formId').val(setting.id); //
                $('#inputHadir').val(setting.in_message); //
                $('#inputPulang').val(setting.out_message); //

                $('#pesan-masuk').text(setting.in_message);
                $('#pesan-pulang').text(setting.out_message);

                // Optional: Highlight tombol terpilih
                $('.btn-unit').removeClass('btn-primary').addClass('btn-secondary');
                $(this).removeClass('btn-secondary').addClass('btn-primary');
            });

            // Trigger default selection (e.g., TK)
            $('.btn-unit[data-unit="TK"]').click();
        });

        const inputHadir = document.getElementById('inputHadir');
        const displayHadir = document.getElementById('pesan-masuk');
        const inputPulang = document.getElementById('inputPulang');
        const displayPulang = document.getElementById('pesan-pulang');
        let timeoutId;

        inputHadir.addEventListener('input', () => {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(() => {
                let result = inputHadir.value.replace(/{nama}/g, "Nur Khoiriah Sitompul");
                displayHadir.textContent = result; // Show the input value
            }, 200); // 500 ms
        });

        inputPulang.addEventListener('input', () => {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(() => {
                let result = inputPulang.value.replace(/{nama}/g, "Nur Khoiriah Sitompul");
                displayPulang.textContent = result; // Show the input value
            }, 200); // 500 ms
        });
    </script>
@endsection
