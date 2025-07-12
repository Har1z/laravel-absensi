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
            width: 26rem;
            height: 26rem;
            border-radius: 50%;
            background-color: #dee2e6;
            background-image: url('https://picsum.photos/500'); // use asset later?
            background-size: cover;
            background-position: center;
            margin-left: auto;
            margin-right: auto;
            margin-top: 1.25rem;
        }

        .log-card {
            overflow-y: auto;
            height: 32rem;
        }

        .info-card {
            height: 39rem;
        }

        .stat-card {
            height: 39rem;
        }
    </style>
@endsection

@section('content')

    <!-- Content Row -->
    <div class="row">

        <div class="col-xl-4 col-lg-4">
            <!-- Input ID -->
            <div class="card shadow mb-1 p-2">
                <label for="input" class="form-label font-weight-bold">Nomor ID</label>
                <input type="text" class="form-control" id="input">
                <p class="text-xs ml-auto mr-2" style="margin-bottom: 0%; margin-top: 2px;"> *Press Enter to Submit</p>
            </div>

            <!-- Log Absensi -->
            <div class="log-card card shadow mb-3 p-2">

                <!-- Absen masuk -->
                <p class="btr-icon-split m-2">
                    <span class="icon text-gray-600">
                        <i class="fas fa-arrow-right"></i>
                    </span>
                    <span class="text">absen masuk</span>
                </p>

                <!-- Absen pulang -->
                <p class="btr-icon-split m-2">
                    <span class="icon text-gray-600">
                        <i class="fas fa-arrow-right"></i>
                    </span>
                    <span class="text">absen pulang</span>
                </p>

            </div>
        </div>

        <div class="col-xl-6 col-lg-6">
            <div class="info-card card shadow mb-3 text-center p-2">
                <div class="student-photo"></div>
                <div class="card bg-success text-white shadow mt-auto p-2">
                    <h3 class="font-weight-bold">Nama</h3>
                    <h3 class="font-weight-bold">Kelas</h3>
                    <h3 class="font-weight-bold">00:00</h3>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-lg-2">
            <div class="stat-card card shadow mb-3 text-center p-2">
                <h4 class="font-weight-bold mb-3">Laporan Absensi</h4>

                <div class="card bg-success text-white shadow mb-2 pt-2 pb-4">
                    <h1 class="font-weight-bold">0</h1>
                    <h3 class="font-weight-bold">Tepat Waktu</h3>
                </div>
                <div class="card bg-warning text-white shadow mb-2 pt-2 pb-4">
                    <h1 class="font-weight-bold">0</h1>
                    <h3 class="font-weight-bold">Terlambat</h3>
                </div>
                <div class="card bg-danger text-white shadow mb-2 pt-2 pb-4">
                    <h1 class="font-weight-bold">0</h1>
                    <h3 class="font-weight-bold">Alpa</h3>
                </div>
                <div class="card bg-primary text-white shadow mb-2 pt-2 pb-4">
                    <h1 class="font-weight-bold">0</h1>
                    <h3 class="font-weight-bold">Total</h3>
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
