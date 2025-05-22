@extends('layouts.attendance')
@section('header')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">

<!-- App Header -->
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Permit Form</div>
    <div class="right"></div>
</div>
@endsection

@section('content')
<br><br><br>
<div class="row">
    <div class="col">
        <form method="POST" action="">
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <input type="text" class="form-control datepicker" name="date" id="data" placeholder="Date">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('myscript')
<script>
    var currYear = (new Date()).getFullYear();

    $(document).ready(function() {
    $(".datepicker").datepicker({
        defaultDate: new Date(currYear-5,1,31),
        // setDefaultDate: new Date(2000,01,31),
        maxDate: new Date(currYear-5,12,31),
        yearRange: [2020, currYear-5],
        format: "yyyy/mm/dd"    
    });
    });
</script>
    
@endpush