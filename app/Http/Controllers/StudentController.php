<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\CourseModel;
use App\Models\EventModel;
use App\Models\AttendanceModel;
use App\Models\FeedbackModel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class StudentController extends Controller
{
    public function index()
    {   
        $id = session('course_id');
        $courseData = CourseModel::all();
        $events = EventModel::select('t_events.id as eid', 't_events.*', 't_courses.*')
            ->join('t_courses', 't_courses.id', 't_events.event_course')
            ->where('event_course', $id)
            ->orWhere('event_course', 255)
            ->get();

        return view('students.index')->with([
            'events' => $events,
            'courses' => $courseData
        ]);
    }

    public function profile($event_id)
    {
        $sid = session('student_id');

        $event_info = EventModel::where('id', $event_id)->first();
        $qrCode = QrCode::size(300)->generate($sid);

        $feedback = FeedbackModel::where('student_id', $sid)
        ->where('event_id', $event_id)->first();

        $attendance = AttendanceModel::where('attend_event_id', $event_id)
        ->where('attend_student_id', $sid)
        ->orderBy('id', 'DESC')
        ->get();

        $course_info = CourseModel::where('id', $event_info->event_course)->first();
        return view('students.activity')->with([
            'event_id' => $event_id,
            'event' => $event_info,
            'qrCode' => $qrCode,
            'attendance' => $attendance,
            'course' => $course_info,
            'feedback' => $feedback
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'inp_et' => 'required|string|max:255',
            'inp_ed' => 'string|max:255',
            'inp_esd' => 'required|date|max:255',
            'inp_eed' => 'required|date|max:255',
            'inp_el' => 'required|string|max:255',
            'inp_ce' => 'required|integer',
        ]);

        $builder = new EventModel([
            'event_name' => $request->input('inp_et'),
            'event_description' => $request->input('inp_ed'),
            'event_start_date' => $request->input('inp_esd'),
            'event_end_date' => $request->input('inp_eed'),
            'event_location' => $request->input('inp_el'),
            'event_course' => $request->input('inp_ce'),
            'created_by ' => 12345,
        ]);

        $builder->save();

        return redirect()->back()->with('success', 'New Event has been added!');
    }
}
