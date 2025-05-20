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
                            $monthName = [
                                1 => 'January',
                                2 => 'February',
                                3 => 'March',
                                4 => 'April',
                                5 => 'May',
                                6 => 'June',
                                7 => 'July',
                                8 => 'August',
                                9 => 'September',
                                10 => 'October',
                                11 => 'November',
                                12 => 'December'
                            ];
                        @endphp
                        @for ($i = 1; $i <= 12; $i++) <option value="{{ $i }}" {{ date("m") == $i ? 'selected' : '' }}>{{ $monthName[$i] }}</option>
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
            var year = $('#tahun').val();
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