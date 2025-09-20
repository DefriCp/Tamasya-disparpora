<!DOCTYPE html>
<html lang="en">

<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- @vite(['resources/css/frontend.css', 'resources/js/app.js']) --}}
    @include('fe.layouts.head')
</head>

<body class="bg-white">
    @include('fe.layouts.navbar')

    @yield('content')

    @include('fe.layouts.script')

    @include('fe.layouts.footer')
</body>

</html>
