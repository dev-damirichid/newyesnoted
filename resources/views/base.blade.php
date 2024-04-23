<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:title" content="Your Title">
    <meta name="twitter:title" content="Your Title">

    <meta name="description" content="Your Description">
    <meta property="og:description" content="Your Description">
    <meta name="twitter:description" content="Your Description">

    <meta property="og:image" content="img_url">
    <meta name="twitter:image" content="img_url">

    <link rel="icon" href="{{ asset('') }}assets/images/favicon-32x32.png" type="image/png" />
    <!--plugins-->
    <link href="{{ asset('') }}assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
    <link href="{{ asset('') }}assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link href="{{ asset('') }}assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
    <link href="{{ asset('') }}assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
    <!-- Bootstrap CSS -->
    <link href="{{ asset('') }}assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="{{ asset('') }}assets/css/bootstrap-extended.css" rel="stylesheet" />
    <link href="{{ asset('') }}assets/css/style.css" rel="stylesheet" />
    <link href="{{ asset('') }}assets/css/icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


    <!-- loader-->
    <link href="{{ asset('') }}assets/css/pace.min.css" rel="stylesheet" />
    @stack('css')

    {{-- <title>{{ $data->title }} - {{ env('APP_NAME') }}</title> --}}
    @livewireStyles
</head>

<body>
    @include('sweetalert::alert')
    <!--start wrapper-->
    <div class="wrapper">
        <!--start top header-->
        @include('partials.header')
        <!--end top header-->

        <!--start sidebar -->
        @include('partials.sidebar')
        <!--end sidebar -->

        <!--start content-->
        <main class="page-content">
            @yield('content')
        </main>
        <!--end page main-->

        <!--start overlay-->
        <div class="overlay nav-toggle-icon"></div>
        <!--end overlay-->

        <!--Start Back To Top Button-->
        <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
        <!--End Back To Top Button-->

    </div>
    <!--end wrapper-->


    <!-- Bootstrap bundle JS -->
    <script src="{{ asset('') }}assets/js/bootstrap.bundle.min.js"></script>
    <!--plugins-->
    <script src="{{ asset('') }}assets/js/jquery.min.js"></script>
    <script src="{{ asset('') }}assets/plugins/simplebar/js/simplebar.min.js"></script>
    <script src="{{ asset('') }}assets/plugins/metismenu/js/metisMenu.min.js"></script>
    <script src="{{ asset('') }}assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--app-->
    <script src="{{ asset('') }}assets/js/app.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function() {
            $("form").submit(function() {
                const button = $(this).find('button[type=submit]');
                button.attr("disabled", true);
                button.text("Loading...");
                return true;
            });

            $("a.btn").click(function() {
                const button = $(this);
                button.addClass("disabled");
                button.text("Loading...");
                return true;
            });

            $('#logout').submit(function() {
                event.preventDefault();
                Swal.fire({
                    title: 'Logout!',
                    text: "Are you sure you want to logout?",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Logout'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).trigger('submit')
                        Swal.close()
                    }
                });
            })
        });
    </script>
    @livewireScripts
    @stack('js')

</body>

</html>
