<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
        $today = date('Y-m-d');
        $this_month = date('m') * 1;
        $this_year = date('Y');
        $employee_id = Auth::user()->employee_id;
        $today_attendance = DB::table('attendance')
            ->where('employee_id', $employee_id)
            ->where('attd_date', $today)->first();
        
        $history_this_month = DB::table('attendance')
            ->where('employee_id', $employee_id)
            ->whereMonth('attd_date','=',$this_month)
            ->whereYear('attd_date','=',$this_year)
            ->orderBy('attd_date')
            ->get();

        //select 
        $attendance_recap = DB::table('attendance')
        ->selectRaw('COUNT(employee_id) as total_attendance, SUM(IF(clock_in > "00:10",1,0)) as total_late')
        ->where('employee_id', $employee_id)
        ->whereRaw('MONTH(attd_date)="'.$this_month.'"')
        ->whereRaw('YEAR(attd_date)="'.$this_year.'"')
        ->first();

        // dd($attendance_recap);

        //select join
        $leaderboard = DB::table('attendance')
            ->join('employee', 'attendance.employee_id', '=', 'employee.employee_id')
            ->where('attd_date', $today)
            ->orderBy('clock_in', 'asc')
            ->get();

        $month_name = array(
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
        );

        $permitRecap = DB::table('permit')
        ->selectRaw('SUM(IF(status = "p",1,0)) as total_permit,SUM(IF(status = "s",1,0)) as total_sick')
        ->where('employee_id', $employee_id)
        ->whereMonth('permit_date','=',$this_month)
        ->whereYear('permit_date','=',$this_year)
        ->where('approval_status', 1)
        ->first();

        return view('dashboard.dashboard',compact('today_attendance','history_this_month','month_name','this_month','this_year', 'attendance_recap', 'leaderboard', 'permitRecap'));
    }
}
