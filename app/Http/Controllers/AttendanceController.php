<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class AttendanceController extends Controller
{
    public function create(){
        $today = date("Y-m-d");
        //employee id
        $employee_id = Auth::guard('employee')->user()->employee_id;
        $check = DB::table('attendance')->where('employee_id', $employee_id)->where('attd_date', $today)->count();
        return view('attendance.create', compact('check'));
    }
    public function store(Request $request)
    {

        $employee_id = Auth::guard('employee')->user()->employee_id;
        $attd_date = date("Y-m-d");
        $clock = date("H:i:s");
        $lat_office = -6.279224178172397;
        $long_office = 107.18188250564448;
        $loc = $request->location;
        $user_loc = explode(",", $loc);
        $user_lat = $user_loc[0];
        $user_long = $user_loc[1];

        $distance = $this->distance($lat_office, $long_office, $user_lat, $user_long);
        $radius = round($distance['meters']);
        $check = DB::table('attendance')->where('employee_id', $employee_id)->where('attd_date', $attd_date)->count();

        if ($check > 0) {
            $info = "out";
        } else {
            $info = "in";
        }
        $image = $request->image;
        $folderPath = "public/uploads/attendance/";
        $formatName = $employee_id . "-" . $attd_date . "-" . $info;
        $imageParts = explode(";base64", $image);
        $imageBase64 = base64_decode($imageParts[1]);
        $fileName = $formatName . ".png";
        $file = $folderPath . $fileName;
        
        
        if($radius > 1500) {
            echo "error|Sorry, you are outside the office radius, your radius {$radius} meter|radius";
            return;
        } else {
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
                    echo "error|Sorry, there was an error while clock out.|out";
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
                    echo "error|Sorry, there was an error while clock in.|in";
                }
            }
        }
        
        
    }

    //calculate distance between two coordinates
    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }

    public function editprofile()
    {   $employee_id = Auth::guard('employee')->user()->employee_id;
        $employee = DB::table('employee')->where('employee_id', $employee_id)->first();
        
        return view('attendance.editprofile', compact('employee'));
    }

    public function updateprofile(Request $request)
    {
        $employee_id = Auth::guard('employee')->user()->employee_id;
        $full_name = $request->full_name;
        $phone_number = $request->phone_number;
        $password = Hash::make($request->password);
        $employee = DB::table('employee')->where('employee_id', $employee_id)->first();

        if ($request->hasFile('photo')) {
            $photo = $employee_id.".".$request->file('photo')->getClientOriginalExtension();
        } else {
            $photo = $employee->photo;
        }

        if(!empty($request->password)){
            $data = [
                'full_name' => $full_name,
                'phone_number' => $phone_number,
                'password' => $password,
                'photo' => $photo
            ];
        } else {
            $data = [
                'full_name' => $full_name,
                'phone_number' => $phone_number,
                'photo' => $photo
            ];
        }

        $update = DB::table('employee')->where('employee_id', $employee_id)->update($data);
        if ($update) {
            if ($request->hasFile('photo')) {
                $folderPath = "public/uploads/employee/";
                $request->file('photo')->storeAs($folderPath, $photo);
            }
            return Redirect::back()->with('success', 'Profile updated successfully');
        } else {
            return Redirect::back()->with('error', 'Failed to update profile');
        }
    }

    public function history(){
        $monthName = ["","January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        return view('attendance.history', compact('monthName'));
    }

    public function gethistory(Request $request)
    {
        $month = $request->month;
        $year = $request->year;
        $employee_id = Auth::guard('employee')->user()->employee_id;

        $history = DB::table('attendance')
            ->whereMonth('attd_date', $month)
            ->whereYear('attd_date', $year)
            ->where('employee_id', $employee_id)
            ->orderBy('attd_date')
            ->get();

        return view('attendance.history', compact('history'));
    }

    public function permit()
    {
        $employee_id = Auth::guard('employee')->user()->employee_id;
        $permitData = DB::table('permit')->where('employee_id', $employee_id)->get();
        $permitCount = DB::table('permit')->where('employee_id', $employee_id)->count();
        return view('attendance.permit', compact('permitData', 'permitCount'));
    }

    public function createpermit()
    {
        return view('attendance.createpermit');
    }
    public function storepermit(Request $request)
    {
        $employee_id = Auth::guard('employee')->user()->employee_id;
        $permit_date = $request->permit_date;
        $status = $request->status;
        $description = $request->description;

        $data = [
            'employee_id' => $employee_id,
            'permit_date' => $permit_date,
            'status' => $status,
            'description' => $description
        ];
        $save = DB::table('permit')->insert($data);
        if($save){
            return redirect('/attendance/permit')->with('success', 'Permit request submitted successfully');
        } else {
            return redirect('/attendance/createpermit')->with('error', 'Failed to submit permit request');
        }
    }
}
