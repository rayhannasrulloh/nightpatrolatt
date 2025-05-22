@extends('layouts.attendance')
@section('header')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
<style>
    .datepicker-modal {
        max-height: 428px !important;
    }
</style>
<!-- App Header -->
<div class="appHeader bg-success text-light">
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
        <form method="POST" action="/attendance/storepermit" id="permitForm">
            @csrf
            <div class="form-group">
                <input type="text" class="form-control datepicker" name="permit_date" id="permit_date" placeholder="Date">
            </div>
            <div class="form-group">
                <select name="status" id="status" class="form-control">
                    <option value="">Status</option>
                    <option value="p">Permit</option>
                    <option value="s">Sick</option>
                </select>
            </div>
            <div class="form-group">
                <textarea name="description" id="description" cols="30" rows="10" placeholder="Description" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <button class="btn btn-primary w-100">Send</button>
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
            format: "yyyy/mm/dd"
        });

        $("#permitForm").submit(function(){
            var permit_date = $("#permit_date").val();
            var status = $("#status").val();
            var description = $("#description").val();

            if (permit_date == "" || status == "" || description == "") {
                alert("Please fill all fields");
                return false;
            }
        })
    });
</script>
    
@endpush