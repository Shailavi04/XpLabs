@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="mb-4">Centers Map</h1>

        <div id="map" style="height: 500px; width: 100%;"></div>
    </div>
@endsection

@push('script')
    <script>
        function initMap() {
            // Dynamic center from first center in DB or fallback
            var mapCenter = {
                lat: {{ $mapCenter->latitude ?? 26.8467 }},
                lng: {{ $mapCenter->longitude ?? 80.9462 }}
            };

            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 6,
                center: mapCenter
            });

            // Add markers dynamically
            var centers = @json($centers);
            centers.forEach(function(center) {
                if (center.latitude && center.longitude) {
                    new google.maps.Marker({
                        position: {
                            lat: parseFloat(center.latitude),
                            lng: parseFloat(center.longitude)
                        },
                        map: map,
                        title: center.name
                    });
                }
            });
        }
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=
    AIzaSyAl_E6ajlHryI0jSHJZndgfesVgswAWOrI
    &callback=initMap" async defer></script>
@endpush
