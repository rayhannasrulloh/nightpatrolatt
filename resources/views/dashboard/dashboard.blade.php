@extends('layouts.attendance')

@section('content')
<div class="section" id="user-section">
    <div id="user-detail">
        <div class="avatar">
            <img src="assets/img/sample/avatar/avatar1.jpg" alt="avatar" class="imaged w64 rounded">
        </div>
        <div id="user-info">
            <h2 id="user-name">Rayhan Roshidi Nasrulloh</h2>
            <span id="user-role">Head of IT</span>
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
                                @php
                                    $path = Storage::url('uploads/attendance/'.$today_attendance->photo_in);
                                @endphp
                                    <img src="{{ url($path) }}" alt="image" class="imaged w48 rounded">
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
                                @php
                                    $path = Storage::url('uploads/attendance/'.$today_attendance->photo_out);
                                @endphp
                                    <img src="{{ url($path) }}" alt="image" class="imaged w48 rounded">
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
                        <span class="badge bg-danger" style="position: absolute; top:3px; right:10px; z-index: 999;">{{ $attendance_recap -> total_late }}</span>
                        <ion-icon name="newspaper-outline" style="font-size: 1.6rem;" class="text-success"></ion-icon>
                        <br>
                        <span style="font-size: 0.8rem">Permit</span>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card">
                    <div class="card-body text-center" style="padding: 12px 12px !important;">
                        <span class="badge bg-danger" style="position: absolute; top:3px; right:10px; z-index: 999;">10</span>
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
                    <li>
                        <div class="item">
                            <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
                            <div class="in">
                                <div>Edward Lindgren</div>
                                <span class="text-muted">Designer</span>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="item">
                            <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
                            <div class="in">
                                <div>Emelda Scandroot</div>
                                <span class="badge badge-primary">3</span>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="item">
                            <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
                            <div class="in">
                                <div>Henry Bove</div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="item">
                            <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
                            <div class="in">
                                <div>Henry Bove</div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="item">
                            <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
                            <div class="in">
                                <div>Henry Bove</div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</div>
@endsection