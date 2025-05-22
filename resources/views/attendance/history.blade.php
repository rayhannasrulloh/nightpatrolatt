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
                        @php
                            $monthName = ["","January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                        @endphp
                        @for ($i = 1; $i <= 12; $i++) 
                        <option value="{{ $i }}" {{ date("m") == $i ? 'selected' : '' }}>{{ $monthName[$i] }}</option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <select name="year" id="year" class="form-control">
                        <option value="">Year</option>
                        @php
                            $startYear = 2023;
                            $currentYear = date('Y');
                        @endphp
                        @for ($year = $startYear; $year <= $currentYear; $year++)
                            <option value="{{ $year }}" {{ date("Y") == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endfor
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <button class="btn btn-primary btn-block" id="searchBtn">
                        <ion-icon name="search-outline"></ion-icon>
                        <strong>Search</strong>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col" id="showHistory"></div>
</div>

@endsection

@push('myscript')
<script>
    $(function() {
        $('#searchBtn').click(function(e) {
            var month = $('#month').val();
            var year = $('#year').val();
            $.ajax({
                type: "POST",
                url: "/gethistory",
                data: {
                    _token: "{{ csrf_token() }}",
                    month: month,
                    year: year
                },
                cache: false,
                success: function(response) {
                    $('#showHistory').html(response);
                }
            });
        });
    });
</script>
@endpush