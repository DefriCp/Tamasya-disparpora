<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

@stack('meta-seo')

<link rel="stylesheet" href="{{ asset('css/frontend/mystyle.css') }}">
<link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
<link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

{{-- <link href="{{ asset('css/frontend/fontawesome.css') }}" rel="stylesheet"> --}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

<link href="{{ asset('css/frontend/swiper-bundle.min.css') }}" rel="stylesheet">

<!-- Leaflet AWAL -->
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

<!-- Leaflet JavaScript -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="https://cdn.jsdelivr.net/npm/@turf/turf@6/turf.min.js"></script>

<!-- Leaflet.TextPath plugin -->
<script src="https://cdn.jsdelivr.net/npm/leaflet-textpath@1.2.0/leaflet.textpath.min.js"></script>
<!-- Leaflet AKHIR-->

@stack('custom-css')

<style>
    .navbar {
        backdrop-filter: blur(5px);
        background-color: rgba(255, 255, 255, 0.05);
        transition: background-color 0.3s ease;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .navbar-scrolled {
        background: linear-gradient(to right, {{ $header->warna_pertama ?? '#377ded' }}, {{ $header->warna_kedua ?? '#377ded' }}) !important;
        transition: background 0.3s ease;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    /* Custom Pagination dengan Tailwind */
    .swiper .swiper-pagination-bullet {
        width: 10px;
        height: 10px;
        background: {{ $header->warna_text_utama ?? '#377ded' }} !important;
        opacity: 0.7;
        transition: all 0.3s ease;
    }

    .swiper .swiper-pagination-bullet-active {
        background: rgb(214, 78, 78);
        opacity: 1;
        transform: scale(1.2);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }

    .swiper .swiper-pagination-bullet:hover {
        opacity: 0.9;
        transform: scale(1.1);
    }

    /* Popup Modal */
    .modal-backdrop {
        backdrop-filter: blur(4px);
    }

    .slide-up {
        animation: slideUp 0.3s ease-out;
    }

    .slide-down {
        animation: slideDown 0.3s ease-out;
    }

    @keyframes slideUp {
        from {
            transform: translateY(100%);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    @keyframes slideDown {
        from {
            transform: translateY(-100%);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    /* Button Style */
    .btn-color-primary {
        color: white !important;
        background-color: {{ $header->warna_text_utama ?? '#377ded' }} !important;
        trnasition: opacity 0.3s ease !important;
    }

    .btn-color-primary:hover {
        opacity: 0.9 !important;
    }

    .btn-color-custom {
        border: 1px solid {{ $header->warna_text_utama ?? '#377ded' }};
        color: {{ $header->warna_text_utama ?? '#377ded' }};
    }

    .btn-color-custom:hover {
        color: white;
        background-color: {{ $header->warna_text_utama ?? '#377ded' }};
    }

    /* Focus Style */
    .custom-focus:focus {
        outline: none !important;
        border-color: {{ $header->warna_text_utama ?? '#377ded' }} !important;
    }

    .btn-custom-focus:focus {
        outline: none !important;
    }

    .color-sosmed {
        color: {{ $header->warna_text_header ?? '#fff' }} !important;
    }

    .main {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 15px;
    }

    .map {
        height: 100%;
        width: 100%;
        background-color: rgb(239, 236, 236);
        border: 1px solid;
        border-radius: 3px;
        border-color: rgb(170, 170, 170);
        border: none;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        position: fixed;
    }
</style>
