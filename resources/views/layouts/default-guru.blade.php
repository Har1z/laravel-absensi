<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title')</title>
    @include('partials.head')
    @yield('custom-style')
</head>
<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        @include('partials.guru-sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            @include('partials.topbar')

            <!-- Main Content -->
                <div id="content">

                    <!-- Page Content -->
                    <div class="container-fluid">

                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">@yield('heading')</h1>
                        </div>

                        @yield('content')

                    </div>
                    <!-- End of Page Content -->

                </div>
            <!-- End of Main Content -->

            @include('partials.footer')

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih “Logout” di bawah ini jika Anda benar-benar ingin logout.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="{{ route('logout') }}">Logout</a>
                </div>
            </div>
        </div>
    </div>
    @yield('modal')

    @include('partials.scripts')
    @yield('custom-scripts')
    <script src="{{ asset('js/filepond/filepond.js') }}"></script>
    <script src="{{ asset('js/filepond/filepond-plugin-image-preview.js') }}"></script>
</body>
</html>
