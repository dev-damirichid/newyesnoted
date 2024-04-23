<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('') }}assets/images/favicon-32x32.png" type="image/png" />
    <!-- Bootstrap CSS -->
    <link href="{{ asset('') }}assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="{{ asset('') }}assets/css/bootstrap-extended.css" rel="stylesheet" />
    <link href="{{ asset('') }}assets/css/style.css" rel="stylesheet" />
    <link href="{{ asset('') }}assets/css/icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <!-- loader-->
    <link href="{{ asset('') }}assets/css/pace.min.css" rel="stylesheet" />

    <title>{{ $data->title }} - {{ env('APP_NAME') }}</title>
</head>

<body>
    @include('sweetalert::alert')
    <!--start wrapper-->
    <div class="wrapper">
        <!--start content-->
        <main class="authentication-content">
            <div class="container-fluid">
                <div class="authentication-card">
                    <div class="row justify-content-center">
                        <h4 class="text-center fw-bold mb-3">
                            {{ env('APP_NAME') }}
                        </h4>

                        @yield('content')

                    </div>
                </div>
            </div>
        </main>

        <!--end page main-->

        <footer class="bg-white border-top p-3 text-center">
            <p class="mb-0">Copyright © <a href="https://damirich.id">Damirich</a> 2023. All right reserved.</p>
        </footer>

    </div>
    <!--end wrapper-->


    <!--plugins-->
    <script src="{{ asset('') }}assets/js/jquery.min.js"></script>
    <script src="{{ asset('') }}assets/js/pace.min.js"></script>
    <script>
        $(document).ready(function() {
            $("form").submit(function() {
                const button = $(this).find('button[type=submit]');
                button.attr("disabled", true);
                button.text("Loading...");
                return true;
            });
        });
    </script>
    @stack('js')


</body>

</html>
