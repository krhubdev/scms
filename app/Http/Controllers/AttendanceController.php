<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
// composer require simplesoftwareio/simple-qrcode

use App\Models\EventModel;
use App\Models\AttendanceModel;
use App\Models\CourseModel;

class AttendanceController extends Controller
{
    public function index($event_id)
    {
        $qr_generate = 'AI:' . hash('SHA256', $event_id . time()) . ':' . $event_id . ':' . time();
        
        $qrCode = QrCode::size(300)->generate($qr_generate);
        $attendance = AttendanceModel::where('attend_event_id', $event_id)->orderBy('id', 'DESC')->get();
        $event_info = EventModel::where('id', $event_id)->first();
        $course_info = CourseModel::where('id', $event_info->event_course)->first();
        return view('attendance.index')->with([
            'event_id' => $event_id,
            'event' => $event_info,
            'qrCode' => $qrCode,
            'attendance' => $attendance,
            'course' => $course_info
        ]);
    }

    public function checkIn()
    {
        session()->put('attendance_status', 'Check-In');
        return redirect()->back();
    }

    public function checkOut()
    {
        session()->put('attendance_status', 'Check-Out');
        return redirect()->back();
    }
}
