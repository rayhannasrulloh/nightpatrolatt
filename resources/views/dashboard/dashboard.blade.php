@extends('layouts.attendance')

@section('content')
<div class="section" id="user-section">
    <div id="user-detail">
        <div class="avatar">
            @if (Auth::guard('employee')->user()->photo)
            @php
                $path = Storage::url('uploads/employee/'.Auth::guard('employee')->user()->photo);
            @endphp
            <img src="{{ url($path) }}" alt="avatar" class="imaged w64 rounded" style="object-fit: cover;">
            @endif
        </div>
        <div id="user-info">
            <h2 id="user-name">{{ Auth::guard('employee')->user()->full_name }}</h2>
            <span id="user-role">{{ Auth::guard('employee')->user()->position }}</span>
        </div>
    </div>
</div>
<div class="section" id="menu-section">
    <div class="card">
        <div class="card-body text-center">
            <div class="list-menu">
                <div class="item-menu text-center">
                    <div class="menu-icon">
                        <a href="" class="green" style="font-size: 40px;">
                            <ion-icon name="person-sharp"></ion-icon>
                        </a>
                    </div>
                    <div class="menu-name">
                        <span class="text-center">Profile</span>
                    </div>
                </div>
                <div class="item-menu text-center">
                    <div class="menu-icon">
                        <a href="" class="green" style="font-size: 40px;">
                            <ion-icon name="calendar-number"></ion-icon>
                        </a>
                    </div>
                    <div class="menu-name">
                        <span class="text-center">Leave</span>
                    </div>
                </div>
                <div class="item-menu text-center">
                    <div class="menu-icon">
                        <a href="" class="green" style="font-size: 40px;">
                            <ion-icon name="document-text"></ion-icon>
                        </a>
                    </div>
                    <div class="menu-name">
                        <span class="text-center">History</span>
                    </div>
                </div>
                <div class="item-menu text-center">
                    <div class="menu-icon">
                        <a href="" class="green" style="font-size: 40px;">
                            <ion-icon name="location"></ion-icon>
                        </a>
                    </div>
                    <div class="menu-name">
                        Location
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="section mt-2" id="presence-section">
    <div class="todaypresence">
        <div class="row">
            <div class="col-6">
                <div class="card gradasigreen">
                    <div class="card-body">
                        <div class="presencecontent">
                            <div class="iconpresence">
                                @if ($today_attendance != null)
                                {{-- @php
                                    $path = Storage::url('uploads/attendance/'.$today_attendance->photo_in);
                                @endphp --}}
                                    <ion-icon name="checkbox-outline"></ion-icon>
                                @else
                                    <ion-icon name="camera"></ion-icon>
                                @endif
                            </div>
                            <div class="presencedetail">
                                <h4 class="presencetitle">In</h4>
                                <span>{{ $today_attendance != null ? $today_attendance->clock_in : 'Not yet present' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card gradasired">
                    <div class="card-body">
                        <div class="presencecontent">
                            <div class="iconpresence">
                                @if ($today_attendance != null && $today_attendance->photo_out != null)
                                {{-- @php
                                    $path = Storage::url('uploads/attendance/'.$today_attendance->photo_out);
                                @endphp --}}
                                    <ion-icon name="checkbox-outline"></ion-icon>
                                @else
                                    <ion-icon name="camera"></ion-icon>
                                @endif
                            </div>
                            <div class="presencedetail">
                                <h4 class="presencetitle">Out</h4>
                                <span>{{ $today_attendance != null && $today_attendance->clock_out != null ? $today_attendance->clock_in : 'Not yet present' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="attendance-recap">
        <h3>Attendance Recap {{ $month_name[$this_month] }} {{ $this_year }}</h3>
        <div class="row">
            <div class="col-3">
                <div class="card">
                    <div class="card-body text-center" style="padding: 12px 12px !important;">
                        <span class="badge bg-danger" style="position: absolute; top:3px; right:10px; z-index: 999;">{{ $attendance_recap -> total_attendance }}</span>
                        <ion-icon name="accessibility-outline" style="font-size: 1.6rem;" class="text-primary"></ion-icon>
                        <br>
                        <span style="font-size: 0.8rem">Present</span>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card">
                    <div class="card-body text-center" style="padding: 12px 12px !important;">
                        <span class="badge bg-danger" style="position: absolute; top:3px; right:10px; z-index: 999;">0</span>
                        <ion-icon name="newspaper-outline" style="font-size: 1.6rem;" class="text-success"></ion-icon>
                        <br>
                        <span style="font-size: 0.8rem">Permit</span>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card">
                    <div class="card-body text-center" style="padding: 12px 12px !important;">
                        <span class="badge bg-danger" style="position: absolute; top:3px; right:10px; z-index: 999;">0</span>
                        <ion-icon name="medkit-outline" style="font-size: 1.6rem;" class="text-danger"></ion-icon>
                        <br>
                        <span style="font-size: 0.8rem">Sick</span>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card">
                    <div class="card-body text-center" style="padding: 12px 12px !important;">
                        <span class="badge bg-danger" style="position: absolute; top:3px; right:10px; z-index: 999;">{{ $attendance_recap -> total_late }}</span>
                        <ion-icon name="alarm-outline" style="font-size: 1.6rem;" class="text-warning"></ion-icon>
                        <br>
                        <span style="font-size: 0.8rem">Late</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="presencetab mt-2">
        <div class="tab-pane fade show active" id="pilled" role="tabpanel">
            <ul class="nav nav-tabs style1" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                        This month
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                        Leaderboard
                    </a>
                </li>
            </ul>
        </div>
        {{-- list bulanan --}}
        <div class="tab-content mt-2" style="margin-bottom:100px;">
            <div class="tab-pane fade show active" id="home" role="tabpanel">
                <ul class="listview image-listview">
                    @foreach ($history_this_month as $d)
                    <li>
                        <div class="item">
                            <div class="icon-box bg-primary">
                                <ion-icon name="finger-print-outline"></ion-icon>
                            </div>
                            <div class="in">
                                <div>{{ date("Y-m-d",strtotime($d->attd_date)) }}</div>
                                <span class="badge badge-success">{{ $d->clock_in }}</span>
                                <span class="badge badge-danger">{{ $today_attendance != null && $d->clock_out != null ? $d->clock_out : 'not yet' }}</span>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            
            {{-- list leaderboard --}}
            <div class="tab-pane fade" id="profile" role="tabpanel">
                <ul class="listview image-listview">
                    @foreach ($leaderboard as $d)
                        
                    <li>
                        <div class="item">
                            <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
                            <div class="in">
                                <div>
                                    <p>{{ $d->full_name }}</p><br>
                                    <small>{{ $d->position }}</small>
                                </div>
                                <span class="badge {{ $d->clock_in < "00:00" ? "bg-success" : "bg-danger" }}  ">
                                    {{ $d->clock_in }}
                                </span>
                            </div>
                        </div>
                    </li>

                    @endforeach
                </ul>
            </div>

        </div>
    </div>
</div>
@endsection