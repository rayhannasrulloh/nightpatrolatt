@extends('layouts.attendance')
@section('header')
<!-- App Header -->
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">NSAP</div>
    <div class="right"></div>
</div>
<!-- * App Header -->
<style>
    .webcam-capture,
    .webcam-capture video{
        display: inline-block;
        width: 100% !important;
        margin: auto;
        height: auto !important;
        border-radius: 15px;
    }

    #map { height: 200px; }
</style>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endsection

@section('content')
<div class="row" style="margin-top: 70px">
    <div class="col">
        <input type="hidden" id="loc">
        <div class="webcam-capture"></div>
    </div>
</div>
<div class="row">
    <div class="col">
        @if ($check > 0)
        <button id="take-attd" class="btn btn-danger btn-block">
            <ion-icon name="camera-outline"></ion-icon>
            Clock-Out
        </button>
        @else
        <button id="take-attd" class="btn btn-primary btn-block">
            <ion-icon name="camera-outline"></ion-icon>
            Clock-In
        </button>
        @endif
    </div>
</div>

<div class="row mt-2">
    <div class="col">
        <div id="map"></div>
    </div>
</div>

<audio id="notif_in">
    <source src="{{ asset('assets/sound/tung-tung.mp3') }}" type="audio/mpeg">
</audio>
<audio id="notif_out">
    <source src="{{ asset('assets/sound/tung-tung.mp3') }}" type="audio/mpeg">
</audio>
@endsection

@push('myscript')
<script>

    var notif_in = document.getElementById('notif_in');
    var notif_out = document.getElementById('notif_out');
    
    Webcam.set({
        width: 480,
        height: 320,
        image_format: 'jpeg',
        jpeg_quality: 80
    });

    Webcam.attach('.webcam-capture');

    var loc = document.getElementById('loc');
    if (navigator.geolocation){
        navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
    }

    function successCallback(position){
        loc.value = position.coords.latitude+", "+position.coords.longitude;
        var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 15);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);
        var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
        var circle = L.circle([-6.282546214416058, 107.17053610376627], {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5,
            radius: 40
        }).addTo(map);
    }

    function errorCallback(){

    }

    $("#take-attd").click(function(e) {
        Webcam.snap(function(uri){
            image = uri;
        });

        var loca = $("#loc").val();
        $.ajax({
            type: 'POST',
            url: '/attendance/store',
            data: {
                _token: "{{ csrf_token() }}",
                image: image,
                location: loca
            },
            cache: false,
            success: function(respond){
                var status = respond.split("|");
                if(status[0] == "success"){
                    if(status[2]=="in"){
                        notif_in.play();
                    } else {
                        notif_out.play();
                    }
                    Swal.fire({
                        title: 'Success!',
                        text: status[1],
                        icon: 'success'
                    });
                    setTimeout(function() {
                        window.location.href = '/dashboard';
                    }, 2000);
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Sorry, error occurred!',
                        icon: 'error'
                    });
                }
            }
        });
    });
</script>
@endpush