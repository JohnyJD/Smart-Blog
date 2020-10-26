<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.ckeditor.com/4.10.0/standard/ckeditor.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,700&display=swap" rel="stylesheet">

    <!-- Icon -->
    <link rel="icon" href="web_images/logo-blue.svg" type="image/svg">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Nunito;
        }

        .auth-wrapper {
            width: 50%;
            height: auto;
            padding: 25px 10px;
            display: flex;
            flex-direction: row;
            justify-content: center;
            background: #00CEFF;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .auth-wrapper form {
            width: 100%;
        }
        .auth-wrapper h2 {
            text-align: center;
            font-size: 2.3em;
            color: white;
        }
        .auth-wrapper .form-group {
            width: 80%;
            margin: 20px auto;
        }
        .auth-wrapper label {
            color: white;
            font-size: 1.3em;
        }
        .auth-wrapper input {
            width: 100%;
            border: none;
            padding: 10px 5px;
            outline: none;
            font-size: .8em;
        }
        .auth-wrapper a {
            text-decoration: none;
            color: white;
            font-weight: bold;
        }
        .auth-wrapper button {
            background: white;
            color: #00CEFF;
            padding: 5px 15px;
            font-size: 1.5em;
            border: none;
            cursor: pointer;
        }
        .auth-wrapper .invalid-feedback {
            color: red;
        }
        .form-check {
            display: block;
            position: relative;
            padding-left: 35px;
            margin-bottom: 15px;
            cursor: pointer;
            font-size: 22px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .form-check input {
            position: absolute;
            opacity: 0;
            left: 0;
            z-index: 10;
            cursor: pointer;
            height: 25px;
            width: 25px;
        }

        .checkmark {
            position: absolute;
            top: 3px;
            left: 0;
            height: 25px;
            width: 25px;
            background-color: #ffffff;
        }

        .form-check:hover input ~ .checkmark {
            background-color: #eaeaea;
        }

        .form-check input:checked ~ .checkmark {
            background-color: #2196F3;
        }

        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }

        .form-check input:checked ~ .checkmark:after {
            display: block;
        }

        .form-check .checkmark:after {
            left: 9px;
            top: 5px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 3px 3px 0;
            -webkit-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            transform: rotate(45deg);
        }


        .main-logo {
            display: flex;
            align-content: center;
            padding: 10px 20px;
            width: fit-content;
        }
        .main-logo svg {
            max-width: 60px;
            height: auto;
        }
        .main-logo h1 {
            font-weight: bold;
            margin-left: 10px;
            color: #00CEFF;
        }
        a {
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div id="app">
        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>
