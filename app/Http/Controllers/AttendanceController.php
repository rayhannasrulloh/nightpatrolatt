<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function create(){
        $today = date("Y-m-d");
        $employee_id = Auth::guard('employee')->user()->employee_id;
        $check = DB::table('attendance')->where('employee_id', $employee_id)->where('attd_date', $today)->count();
        return view('attendance.create', compact('check'));
    }
    public function store(Request $request)
    {
        $employee_id = Auth::guard('employee')->user()->employee_id;
        $attd_date = date("Y-m-d");
        $clock = date("H:i:s");
        $loc = $request->location;
        $image = $request->image;
        $folderPath = "public/uploads/attendance/";
        $formatName = $employee_id . "-" . $attd_date;
        $imageParts = explode(";base64", $image);
        $imageBase64 = base64_decode($imageParts[1]);
        $fileName = $formatName . ".png";
        $file = $folderPath . $fileName;
        
        $check = DB::table('attendance')->where('employee_id', $employee_id)->where('attd_date', $attd_date)->count();
        if ($check > 0) {
            $data_out = [
                'photo_out' => $fileName,
                'clock_out' => $clock,
                'location_out' => $loc,
            ];
            $update = DB::table('attendance')->where('employee_id', $employee_id)->where('attd_date', $attd_date)->update($data_out);
            if ($update) {
                echo "success|Thank you, you have clocked out successfully.|out";
                Storage::put($file, $imageBase64);
            } else {
                echo "error|Sorry, there was an error while attendance.|out";
            }
        } else {
            $data_in = [
                'employee_id' => $employee_id,
                'attd_date' => $attd_date,
                'photo_in' => $fileName,
                'clock_in' => $clock,
                'location_in' => $loc,
            ];
            $save = DB::table('attendance')->insert($data_in);
            if ($save) {
                echo "success|Thank you, you have clocked in successfully|in";
                Storage::put($file, $imageBase64);
            } else {
                echo "error|Sorry, there was an error while attendance.|in";
            }
        }
        
    }
}
