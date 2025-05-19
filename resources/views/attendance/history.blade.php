@extends('layouts.attendance')
@section('header')
<!-- App Header -->
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Attendance History</div>
    <div class="right"></div>
</div>
@endsection
@section('content')
<br><br><br>
<div class="row">
    <div class="col">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <select name="month" id="month" class="form-control">
                        <option value="">Month</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}">{{ $monthName[$i] }}</option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <select name="tahun" id="tahun" class="form-control">
                        <option value="">Tahun</option>
                        @php
                            $startYear = 2023;
                            $currentYear = date('Y');
                        @endphp
                        @for ($year = $startYear; $year <= $currentYear; $year++)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <button class="btn btn-primary btn-block">
                        <ion-icon name="search-outline"></ion-icon>
                        <strong>Search</strong>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection