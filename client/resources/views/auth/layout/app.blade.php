<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>KP Online</title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link rel="stylesheet" href="{{URL::asset('bootstrap_framework/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('dist/css/skins/skin-blue.min.css') }}">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="{{ URL::asset('dist/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('dist/css/skins/skin-blue.min.css') }}">

    <style>
        body {
            font-family: 'Lato';
            background-color: #ecf0f5;
        }
        .container{
            margin-top:150px;
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
</head>
<body id="app-layout">

<!-- Content Wrapper. Contains page content -->

<!-- Content Header (Page header) -->

<!-- Main content -->
<section class="content">

    <!-- Your Page Content Here -->
    @yield('content')

</section><!-- /.content -->


<!-- JavaScripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
{{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</body>
</html>
