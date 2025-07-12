<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Login</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
        <style>
            .clock-panel {
                background: url('https://absensi.sekolahlaboratoriumjakarta.com/public/resources/images/sekolah-login.jpeg') no-repeat center center/cover;
                position: relative;
            }

            .clock-overlay {
                backdrop-filter: blur(6px);
                background: rgba(0, 0, 0, 0.4);
                position: absolute;
                inset: 0;
            }

            canvas {
                background: transparent;
            }

        </style>
    </head>
    <body class="bg-success">

        <div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center">
            <div class="row w-100 shadow-lg rounded-4 overflow-hidden bg-white" style="max-width: 960px;">

            <!-- Left Panel -->
            <div class="d-md-block d-none col-md-6 p-4 bg-dark position-relative text-white clock-panel">
                <div class="clock-overlay d-flex flex-column align-items-center justify-content-center text-center h-100">
                    <canvas id="analogClock" width="200" height="200"></canvas>
                    <h3 id="digitalClock" class="mt-3"></h3>
                    <p id="date" class="fs-5 fw-bold"></p>
                </div>
            </div>

            <!-- Right Panel -->
            <div class="col-md-6 p-5 d-flex flex-column justify-content-center">
                <div class="text-center mb-4">
                    <img src="{{ asset('images/logo-yayasan.png') }}" alt="Logo" width="60" class="mb-3">
                    <h2 class="fw-bold">Lab Attendance</h2>
                    <p class="text-muted">Sign into your account</p>
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{session('error')}}
                        </div>
                    @endif
                </div>
                <form method="post" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email address" required />
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" autocomplete="off" required />
                    </div>
                    <div class="mb-3">
                        <input type="checkbox" name="rememberme" id="rememberme" class="form-check-input" autocomplete="off" />
                        <label class="form-check-label" for="rememberme">Remember me</label>
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-dark" type="submit">Login</button>
                    </div>
                </form>
                <p class="text-center text-muted mt-4 mb-0">&copy; 2023-2025</p>
            </div>

            </div>
        </div>

        <script async>
            const canvas = document.getElementById("analogClock");
            const ctx = canvas.getContext("2d");
            const radius = canvas.height / 2;

            function drawClock() {
                const now = new Date();

                // Digital Clock
                const time = now.toLocaleTimeString('id-ID');
                document.getElementById("digitalClock").textContent = time;

                // Date
                const date = now.toLocaleDateString('id-ID', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
                document.getElementById("date").textContent = date;

                // Clear and set origin
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                ctx.save();
                ctx.translate(radius, radius);

                // Draw clock face
                drawClockFace(ctx, radius);

                // Time values with fractions
                const sec = now.getSeconds() + now.getMilliseconds() / 1000;
                const min = now.getMinutes() + sec / 60;
                const hr = now.getHours() % 12 + min / 60;

                // Angles
                const secAngle = (sec * Math.PI / 30);
                const minAngle = (min * Math.PI / 30);
                const hrAngle = (hr * Math.PI / 6);

                drawHand(ctx, hrAngle, radius * 0.5, 6);        // Hour
                drawHand(ctx, minAngle, radius * 0.8, 4);       // Minute
                drawHand(ctx, secAngle, radius * 0.9, 2); // Second

                ctx.restore();

                // Animate
                requestAnimationFrame(drawClock);
            }

            function drawClockFace(ctx, radius) {
                // Outer circle
                ctx.beginPath();
                ctx.arc(0, 0, radius - 5, 0, 2 * Math.PI);
                ctx.strokeStyle = "#fff";
                ctx.lineWidth = 4;
                ctx.stroke();

                // Hour marks
                for (let i = 0; i < 12; i++) {
                    const angle = i * Math.PI / 6;
                    const x1 = Math.cos(angle) * (radius - 10);
                    const y1 = Math.sin(angle) * (radius - 10);
                    const x2 = Math.cos(angle) * (radius - 20);
                    const y2 = Math.sin(angle) * (radius - 20);
                    ctx.beginPath();
                    ctx.moveTo(x1, y1);
                    ctx.lineTo(x2, y2);
                    ctx.strokeStyle = "#fff";
                    ctx.lineWidth = 2;
                    ctx.stroke();
                }
            }

            function drawHand(ctx, angle, length, width, color = "#fff") {
                ctx.save();
                ctx.rotate(angle);
                ctx.beginPath();
                ctx.moveTo(0, 0);
                ctx.lineTo(0, -length);
                ctx.strokeStyle = color;
                ctx.lineWidth = width;
                ctx.lineCap = "round";
                ctx.stroke();
                ctx.restore();
            }

            drawClock(); // Initial call
        </script>

    </body>
</html>
