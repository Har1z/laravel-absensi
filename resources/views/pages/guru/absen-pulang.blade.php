@extends('layouts.default-absen')

@section('title')
    Absensi Siswa - Lab Attendance
@endsection

@section('heading')

@endsection

@section('custom-style')
    <!-- Custom styles for this page -->

@endsection

@section('content')

    <!-- Loader -->
    <div class="loader-overlay d-none" id="loader">
        <div class="loader"></div>
    </div>


    <!-- Content Row -->
    <div class="row">

        <div class="main-panel">
            <div class="content">
                <div class="container-fluid">
                    <div class="row mx-auto">
                        <div class="col-lg-3 col-xl-4 mb-1">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="mt-2"><b>Note</b></h3>
                                    <ul class="pl-3">
                                        <li>Halaman ini hanya digunakan untuk absen pulang saja</li>
                                        <li>Jika ada siswa yang discan melalui halaman ini maka siswa tersebut akan dinyatakan absen pulang</li>
                                        {{-- <li>idk what to say</li> --}}
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-4 mb-1">
                            <div class="card">
                                <div class="col-10 mx-auto card-header card-header-primary rounded-lg bg-warning"
                                    style="margin-top:10px;">
                                    <div class="row">
                                        <div class="col">
                                            <h4 class="card-title text-white"><b>Absen pulang</b></h4>
                                            <p class="card-category text-white">Silahkan tunjukkan QR Code anda</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body my-auto px-5">


                                    <br>

                                    <div class="row">
                                        <div class="col-sm-12 mx-auto">
                                            <div class="previewParent">
                                                <div class="text-center">
                                                    <h4 class="d-none w-100" id="searching"><b>Mencari...</b></h4>
                                                </div>
                                                <div id="previewKamera" height="300px" width="300px"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <style>
                                        .text-pink-pastel {
                                            color: #ffc5d3 !important;
                                        }

                                        .hasil-scan {
                                            position: relative;
                                            /* Mengatur kontainer agar bisa menampung elemen canvas dengan posisi absolute */
                                        }

                                        .canvas-background {
                                            position: absolute;
                                            top: 0;
                                            left: 0;
                                            width: 100%;
                                            height: 100%;
                                            z-index: 10;
                                            /* Pastikan canvas berada di bawah konten lainnya */
                                            background-color: transparent;
                                            /* Pastikan latar belakang canvas transparan */
                                            /* border-style: dotted; */
                                        }

                                        canvas {
                                            /* background-color: #000; */
                                            width: 100%;
                                            height: 100%;
                                        }
                                    </style>
                                    <div style="position: relative;">
                                        <canvas id="canvas" class="canvas-background" style="display: none;"></canvas>
                                        <div id="hasilScan" class="hasil-scan mt-2">
                                            {{-- <h3 class="text-danger">Data Tidak Ditemukan</h3>

                                            <div class="row w-100">
                                                <div class="col">
                                                    <p>Nama : <b>######</b></p>
                                                    <p>Unit : <b>SD</b></p>
                                                </div>
                                                <div class="col">
                                                    <p>Jam masuk : <b class="text-info">06:23:05</b></p>
                                                    <p>Jam pulang : <b class="text-info">-</b></p>
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                    <br>

                                    <h4 class="d-inline">Pilih kamera</h4>

                                    <select id="pilihKamera" class="custom-select w-50 ml-2"
                                        aria-label="Default select example" style="height: 35px;">
                                        <option selected>Select camera devices</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-xl-4 mb-1">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="mt-2 mb-3"><b>Pengaturan</b></h3>
                                    {{-- <ul class="pl-3">
                                        <li>Jika berhasil scan maka akan muncul data siswa/guru dibawah preview kamera</li>
                                    </ul> --}}
                                    <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-icon-split btn-md" title="cancel">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-xmark"></i>
                                        </span>
                                        <span class="text">Kembali ke dashboard</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <!-- Notification -->
    <button type="button" id="notification-btn" class="btn btn-primary d-none" data-toggle="modal" data-target="#notification-modal"></button>
    <div class="modal fade" id="notification-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Info</h5>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js" integrity="sha512-r6rDA7W6ZeQhvl8S7yRVQUKVHdexq+GAlNkNNqVC7YyIV+NwqCTJe2hDWCiffTyRNOeGEzRRJ9ifvRm/HCzGYg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

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

    <!-- QR scanner script -->
    <script>
        const cameraSelect = document.getElementById("pilihKamera");


        // Fetch cameras and populate the camera selector
        Html5Qrcode.getCameras().then(devices => {
            if (devices && devices.length) {
                devices.forEach(device => {
                    const option = document.createElement("option");
                    option.value = device.id;
                    option.text = device.label;
                    cameraSelect.appendChild(option);
                });

                // Start scanning with the first camera by default
                $('#previewKamera').addClass('d-none');
                $('#previewParent').addClass('unpreview');
                $('#searching').removeClass('d-none');
                setTimeout(() => {
                    autoStart();
                }, 300);
            }
        }).catch(err => {
            console.error("Error getting cameras", err);
        });

        // Start scanning when a camera is selected
        cameraSelect.addEventListener("change", (event) => {
            $('#previewKamera').addClass('d-none');
            $('#previewParent').addClass('unpreview');
            $('#searching').removeClass('d-none');
            setTimeout(() => {
                startScanning(event.target.value);
            }, 300);
        });

        function isMobileDevice() {
            return (typeof window.orientation !== "undefined") || (navigator.userAgent.indexOf('IEMobile') !== -1);
        }

        function startScanning(cameraId) {
            const qrCodeScanner = new Html5Qrcode("previewKamera");
            const qrboxSize = isMobileDevice() ? 170 : 250;  // Lebih kecil untuk mobile

            qrCodeScanner.start(
                cameraId,
                {
                    fps: 20,    // Optional, frame per seconds for qr code scanning
                    qrbox: qrboxSize  // Optional, if you want bounded box UI
                },
                qrCodeMessage => {
                    console.log(`QR Code detected: ${qrCodeMessage}`);
                    cekData(`${qrCodeMessage}`)
                    // Handle the scanned QR code here

                    // Giving the scanner a delay between result
                    qrCodeScanner.pause();
                    if (({{ date('dm') }} == 2305) && (qrCodeMessage == "0089745533")) {
                        document.querySelector("#canvas").setAttribute("style", "display: block;");
                        $('html, body').animate({
                            scrollTop: $("#hasilScan").offset().top
                        }, 500);
                    } else {
                        document.querySelector("#canvas").setAttribute("style", "display: none;");
                    }
                    setTimeout(() => {
                        qrCodeScanner.resume();
                    }, 2000);
                },
                errorMessage => {
                    // Parse error, ignore it
                }
            ).catch(err => {
                console.error("Unable to start scanning", err);
            });

            $('#previewParent').removeClass('unpreview');
            $('#previewKamera').removeClass('d-none');
            $('#searching').addClass('d-none');
        }

        function autoStart() {
            const html5QrCode = new Html5Qrcode("previewKamera");
            const qrboxSize = isMobileDevice() ? 170 : 250;  // Lebih kecil untuk mobile

            html5QrCode.start(
                { facingMode: "environment" },
                {
                    fps: 20,
                    qrbox: qrboxSize
                },
                qrCodeMessage => {
                    console.log(`QR Code detected: ${qrCodeMessage}`);
                    cekData(`${qrCodeMessage}`)
                    // Handle the scanned QR code here

                    // Giving the scanner a delay between result
                    html5QrCode.pause();
                    if (({{ date('dm') }} == 2305) && (qrCodeMessage == "0089745533")) {
                        document.querySelector("#canvas").setAttribute("style", "display: block;");
                        $('html, body').animate({
                            scrollTop: $("#hasilScan").offset().top
                        }, 500);
                    } else {
                        document.querySelector("#canvas").setAttribute("style", "display: none;");
                    }

                    setTimeout(() => {
                        html5QrCode.resume();
                    }, 2000);
                },
                errorMessage => {
                    // Parse error, ignore it
                }).catch(err => {
                    console.error("Unable to start scanning", err);
                });

            $('#previewParent').removeClass('unpreview');
            $('#previewKamera').removeClass('d-none');
            $('#searching').addClass('d-none');
        }

        async function cekData(identifier) {
            $.ajax({
                url: "{{ route('scan.pulang') }}",
                type: 'POST',
                data: {
                    identifier: identifier
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // jika pakai route web
                },
                success: function (res) {
                    console.log(res.console);
                    const resultHTML = `
                                <h3 class="text-${res.color}">${res.msg}</h3>

                                <div class="row w-100">
                                    <div class="col">
                                        <p>Nama : <b>${res.nama ? res.nama : '-'}</b></p>
                                        <p>Unit : <b>${res.unit ? res.unit : '-'}</b></p>
                                    </div>
                                    <div class="col">
                                        <p>Jam masuk : <b class="text-info">${res.masuk ? res.masuk : '-'}</b></p>
                                        <p>Jam pulang : <b class="text-info">${res.pulang ? res.pulang : '-'}</b></p>
                                    </div>
                                </div>
                            `;
                    $('#hasilScan').html(resultHTML);
                },
                error: function (xhr, status, thrown) {
                    console.log(thrown);
                    $('#hasilScan').html(thrown);
                }
            });

            // $.ajax({
            //     url: '{{ route('scan.pulang') }}',
            //     type: 'POST',
            //     data: {
            //         identifier: identifier
            //     },
            //     headers: {
            //         'X-CSRF-TOKEN': '{{ csrf_token() }}' // jika pakai route web
            //     },
            //     success: function (res) {
            //         $("#loader").toggleClass("d-none");
            //         console.log(res);
            //         const resultHTML = `
            //                     <h3 class="text-${res.color}">Data Tidak Ditemukan</h3>

            //                     <div class="row w-100">
            //                         <div class="col">
            //                             <p>Nama : <b>${res.nama ? res.nama : '-'}</b></p>
            //                             <p>Unit : <b>${res.unit ? res.unit : '-'}</b></p>
            //                         </div>
            //                         <div class="col">
            //                             <p>Jam masuk : <b class="text-info">${res.masuk ? res.masuk : '-'}</b></p>
            //                             <p>Jam pulang : <b class="text-info">${res.pulang ? res.pulang : '-'}</b></p>
            //                         </div>
            //                     </div>
            //                 `;
            //         $('#hasilScan').html(resultHTML);
            //     },
            //     error: function (xhr) {
            //         $("#loader").toggleClass("d-none");
            //         $("#hasilScan").text(`${xhr.responseJSON.console || 'Terjadi kesalahan.'}`);
            //     }
            // });
        }
    </script>
@endsection
