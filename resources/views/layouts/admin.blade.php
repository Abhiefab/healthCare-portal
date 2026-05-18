<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css"
    >

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

<body>

    @yield('content')

</body>
</html>