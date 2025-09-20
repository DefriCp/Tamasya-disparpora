<script src="{{ asset('js/frontend/navbar.js') }}"></script>
<script src="{{ asset('js/frontend/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('js/frontend/swiper-config.js') }}"></script>
<script src="{{ asset('js/frontend/fetchapi.js') }}"></script>

<script src="{{ asset('assets/js/leaflet.ajax.js') }}"></script>

<script>
    window.wisataDetailUrl = "{{ url('/tamasya-wisata') }}";
</script>
<script src="{{ asset('assets/js/dashboard.js') }}"></script>

@stack('js')
