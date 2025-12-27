<!DOCTYPE html>
<html lang="id">

<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Pastikan FontAwesome ada --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    @include('fe.layouts.head')
</head>

{{-- FIX: class 'pt-24' memberi jarak atas agar tidak ketutup navbar --}}
<body class="bg-gray-50 font-sans antialiased text-gray-900">
    
    @include('fe.layouts.navbar')

    <main class="min-h-screen">
        @yield('content')
    </main>

    @include('fe.layouts.script')
    @include('fe.layouts.footer')
</body>

</html>