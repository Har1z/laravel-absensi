@extends('layouts.default-absen')

@section('title')
    Absensi Siswa - Lab Attendance
@endsection

@section('heading')

@endsection

@section('custom-style')
    <!-- Custom styles for this page -->
    <style>
        .student-photo {
            width: 20rem;
            height: 20rem;
            border-radius: 50%;
            background-color: #dee2e6;
            /* background-image: url('https://picsum.photos/500'); // use asset later? */
            background-size: cover;
            background-position: center;
            margin-left: auto;
            margin-right: auto;
            margin-top: 1.25rem;
        }

        .log-card {
            overflow-y: auto;
            height: 417px;
        }

        .info-card {
            height: 550px;
        }

        .loader-overlay {
            position: fixed;
            top: 0; left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .loader {
            border: 8px solid #f3f3f3;
            border-top: 8px solid #00af43;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

    </style>
@endsection

@section('content')

    <!-- Loader -->
    <div class="loader-overlay d-none" id="loader">
        <div class="loader"></div>
    </div>


    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-4 col-lg-4">
            <!-- Input ID -->
            <div class="card shadow mb-4 p-2">
                <label for="input" class="form-label font-weight-bold">Nomor ID</label>
                <input type="text" class="form-control" id="input" autofocus>
                <p class="text-xs ml-auto mr-2" style="margin-bottom: 0%; margin-top: 2px;"> *Press Enter to Submit</p>
            </div>

            <!-- Log Absensi -->
            <div class="log-card card shadow mb-3 p-2">

                {{--
                <!-- Absen masuk -->
                <p class="btr-icon-split m-2">
                    <span class="icon text-success">
                        <i class="fas fa-right-to-bracket"></i>
                    </span>
                    <span class="text">[00:00:00] Nama Siswa</span>
                </p>

                <!-- Absen pulang -->
                <p class="btr-icon-split m-2">
                    <span class="icon text-danger">
                        <i class="fas fa-right-from-bracket"></i>
                    </span>
                    <span class="text">[00:00:00] Nama Siswa</span>
                </p>
                --}}

            </div>
        </div>

        <div class="col-xl-8 col-lg-8">
            <div class="info-card card shadow mb-3 text-center p-2">
                <img class="student-photo" id="profile_pict" src=""></img>
                <div class="card text-white shadow mt-auto p-2" style="background-color: purple">
                    <h3 class="font-weight-bold" id="nama">Nama</h3>
                    <h3 class="font-weight-bold" id="unit">unit</h3>
                    <h3 class="font-weight-bold" id="waktu">00:00</h3>
                </div>
            </div>
        </div>

        {{-- <div class="col-xl-2 col-lg-2">
            <div class="stat-card card shadow mb-3 text-center p-2">
                <h4 class="font-weight-bold mb-3">Laporan Absensi</h4>

                <div class="card bg-success text-white shadow mb-2 pt-2 pb-4">
                    <h1 class="font-weight-bold" id="count-tepat-waktu">0</h1>
                    <h3 class="font-weight-bold">Tepat Waktu</h3>
                </div>
                <div class="card bg-warning text-white shadow mb-2 pt-2 pb-4">
                    <h1 class="font-weight-bold" id="count-terlambat">0</h1>
                    <h3 class="font-weight-bold">Terlambat</h3>
                </div>
                <div class="card bg-danger text-white shadow mb-2 pt-2 pb-4">
                    <h1 class="font-weight-bold" id="count-alpa">0</h1>
                    <h3 class="font-weight-bold">Alpa</h3>
                </div>
                <div class="card bg-primary text-white shadow mb-2 pt-2 pb-4">
                    <h1 class="font-weight-bold" id="count-total">0</h1>
                    <h3 class="font-weight-bold">Total</h3>
                </div>

            </div>
        </div> --}}


    </div>


    <!-- Notification -->
    <button type="button" id="notification-btn" class="btn btn-primary d-none" data-toggle="modal" data-target="#notification-modal"></button>
    <div class="modal fade" id="notification-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="message">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
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
    <script>

        $(document).ready(function () {
            getLog();

            // Event submit saat tekan Enter di input
            $('#input').on('keypress', function (e) {
                if (e.which === 13) { // Enter key
                    e.preventDefault();

                    // Jika mode manual aktif, jangan submit otomatis
                    if ($('#manualToggle').is(':checked')) return;

                    submitAbsen();
                }
            });

            function submitAbsen() {
                const id = $('#input').val();

                $("#loader").toggleClass("d-none");

                if (!id) return alert('ID tidak boleh kosong.');

                $.ajax({
                    url: '{{ route('scan') }}',
                    type: 'POST',
                    data: {
                        identifier: id
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // jika pakai route web
                    },
                    success: function (res) {
                        $("#loader").toggleClass("d-none");
                        console.log(res);
                        console.log(res.log);

                        $('#profile_pict').attr('src', res.profile_pict);
                        $('#nama').text(res.nama);
                        $('#unit').text(res.unit);
                        $('#waktu').text(res.waktu);

                        // $('#count-tepat-waktu').text(res.count_tepat_waktu);
                        // $('#count-terlambat').text(res.count_terlambat);
                        // $('#count-alpa').text(res.count_alpa);
                        // $('#count-total').text(res.count_total);

                        getLog();
                        $('#input').val('');
                    },
                    error: function (xhr) {
                        $("#loader").toggleClass("d-none");
                        $("#notification-btn").click();
                        $("#message").text(`${xhr.responseJSON.console || 'Terjadi kesalahan.'}`);
                        $('#input').val('');
                    }
                });
            }

            function getLog() {
                $.ajax({
                    url: '{{ route("absensi.log") }}',
                    type: 'POST',
                    data: {
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function (res) {
                        $('.log-card').empty();

                        res.forEach(res => {
                            const logHTML = `
                                <p class="btr-icon-split m-2">
                                    <span class="icon ${res.type === 'masuk' ? 'text-success' : 'text-danger'}">
                                        <i class="fas fa-${res.type === 'masuk' ? 'right-to-bracket' : 'right-from-bracket'}"></i>
                                    </span>
                                    <span class="text">[${res.time}] ${res.name}</span>
                                </p>
                            `;

                            $('.log-card').prepend(logHTML);
                        });
                    },
                    error: function (xhr) {
                        console.log(xhr.responseJSON.console || 'Terjadi kesalahan.');
                    }
                });
            }
        });

        // date & time
        function startTime() {
            const now = new Date();

            // digital clock
            const today = new Date();
            let h = today.getHours();
            let m = today.getMinutes();
            let s = today.getSeconds();
            m = checkTime(m);
            s = checkTime(s);
            document.getElementById('time').textContent = h + ":" + m + ":" + s;

            // Date
            const date = now.toLocaleDateString('id-ID', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            document.getElementById("date").textContent = date;

            setTimeout(startTime, 1000);
        }

        // fun to add 0 when the number is below 10
        function checkTime(i) {
            return i < 10 ? "0" + i : i;
        }

        startTime();
    </script>
@endsection
