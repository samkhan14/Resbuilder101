<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts Integration -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Open+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- System Fonts (Arial, Calibri, Helvetica, Times New Roman, Tahoma, Verdana) -->
    <style>
        @font-face {
            font-family: 'Calibri';
            src: local('Calibri'), local('Calibri Regular'), local('Calibri-Regular');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'Calibri';
            src: local('Calibri Bold'), local('Calibri-Bold');
            font-weight: bold;
            font-style: normal;
        }

        @font-face {
            font-family: 'Arial';
            src: local('Arial'), local('Arial Regular'), local('Arial-Regular');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'Helvetica';
            src: local('Helvetica'), local('Helvetica Regular'), local('Helvetica-Regular');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'Times New Roman';
            src: local('Times New Roman'), local('Times New Roman Regular');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'Tahoma';
            src: local('Tahoma'), local('Tahoma Regular');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'Verdana';
            src: local('Verdana'), local('Verdana Regular');
            font-weight: normal;
            font-style: normal;
        }
    </style>

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>

<body class="antialiased">
    @inertia
</body>

</html>
