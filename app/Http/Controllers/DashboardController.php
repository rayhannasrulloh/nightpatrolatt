<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
        $today = date('Y-m-d');
        $this_month = date('m');
        $this_year = date('Y');
        $employee_id = Auth::user()->employee_id;
        $today_attendance = DB::table('attendance')
            ->where('employee_id', $employee_id)
            ->where('attd_date', $today)->first();
        $history_this_month = DB::table('attendance')->whereRaw('MONTH(attd_date)="'.$this_month.'"')
        ->whereRaw('YEAR(attd_date)="'.$this_year.'"')
        ->orderBy('attd_date')
        ->get();
        return view('dashboard.dashboard',compact('today_attendance','history_this_month'));
    }
}
