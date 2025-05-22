@extends('layouts.attendance')
@section('header')
<!-- App Header -->
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Permit/Sick Data</div>
    <div class="right"></div>
</div>
@endsection

@section('content')
<br><br><br>
<div class="fab-button">
    <a href="/attendance/createpermit" class="fab">
        <ion-icon name="add"></ion-icon>
    </a>
</div style="margin-left: 10px;">

@endsection