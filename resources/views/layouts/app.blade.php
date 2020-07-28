<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        {{-- <meta name="viewport" content="width=device-width, initial-scale=1"> --}}
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('assets/css/default.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
        <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">

        {{-- additional links per page --}}
        @yield('links')


        <!-- Scripts -->
        {{-- <script src="{{ asset('assets/js/app.js') }}" defer></script> --}}
        {{-- <script src="{{ asset('assets/js/jquery-3.3.1.min.js') }}" defer></script> --}}
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        {{-- <script src="{{ asset('assets/js/popper.min.js') }}" defer></script> --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        {{-- <script src="{{ asset('assets/js/bootstrap.min.js') }}" defer></script> --}}
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

        <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

        <script src="{{ asset('assets/js/select2.min.js') }}" charset="utf-8"></script>
        <script src="{{ asset('assets/js/custom.js') }}" charset="utf-8"></script>
        @yield('scripts')

    </head>
    <body>
        <div id="app">
            @include('layouts.nav')
            <main class="py-4">
                <div class="container">
                    @yield('content')
                </div>
            </main>
        </div>
        <script>
            $('.datatable').DataTable();
        </script>
    </body>
</html>
