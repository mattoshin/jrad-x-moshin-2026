<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />


    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title></title>
</head>
<body>

    <div id="landing"></div>

    <script defer src="/js/manifest.js"></script>
    <script defer src="{{asset('js/vendor.js')}}"></script>
    <script defer src="{{mix('js/app.js')}}"></script>

</body>
</html>
