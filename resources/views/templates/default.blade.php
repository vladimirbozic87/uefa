<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>UEFA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>

    <link rel="stylesheet" href="{{ asset('/css/steps.css') }}">
</head>

<body>

@include('templates.partials.navigation')

<div style="height: 100px"></div>

<div class="container" id="wrapper">
    @include('templates.partials.alert')
    @yield('content')
</div>

</body>
</html>
