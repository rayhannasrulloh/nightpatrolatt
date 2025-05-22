@extends('layouts.attendance')
@section('header')
<!-- App Header -->
<div class="appHeader bg-success text-light">
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
<div class="row">
    <div class="col">
        @php
            $messageSuccess = Session::get('success');
            $messageError = Session::get('error');
        @endphp
        @if (Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ $messageSuccess }}
            </div>
        @endif
        @if (Session::get('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ $messageError }}
            </div>
        @endif
    </div>
</div>

<div class="row">
    <div class="col">
        @foreach ($permitData as $d)
    <ul class="listview image-listview">
        <li>
            <div class="item">
                <div class="in">
                    <div>
                        <b>{{ date("d-m-Y",strtotime($d->permit_date)) }} ({{ $d->status== "s" ? "Sick" : "Permit" }}) </b><br>
                        <small>{{ $d->description }}</small>
                    </div>
                    @if ($d->approval_status == 0)
                        <span class="badge bg-warning">Waiting</span>
                    @elseif ($d->approval_status == 1)
                        <span class="badge bg-success">Approved</span>
                    @elseif ($d->approval_status == 2)
                        <span class="badge bg-danger">Rejected</span>
                    @endif
                </div>
            </div>
        </li>
    </ul>
    @endforeach
    </div>
</div>

<div class="fab-button bottom-right" style="margin-bottom: 80px;">
    <a href="/attendance/createpermit" class="fab">
        <ion-icon name="add"></ion-icon>
    </a>
</div>

@endsection