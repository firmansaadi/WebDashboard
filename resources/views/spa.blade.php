<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

  <head>
    <!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">



<!-- Favicon icon-->
<link rel="shortcut icon" type="image/x-icon" href="../assets/images/favicon/favicon.ico">

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />


<!-- Theme CSS -->
	<link rel="stylesheet" href="{{ asset('assets/css/theme.min.css') }}">
    <title>Laravel</title>
    @vite('resources/css/app.css')
  </head>

  <body>

    <div id="db-wrapper">

    </div>

    <!-- Scripts -->
    <!-- Libs JS -->

<!-- clipboard -->

<!-- Theme JS -->
@vite('resources/js/app.js')
  </body>

</html>
