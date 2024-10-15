<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\CourseModel;
use App\Models\EventModel;
use App\Models\AttendanceModel;
use App\Models\AssignedModel;


class ReportsController extends Controller
{
    public function index()
    {
        $id = session('course_id');
        $courseData = CourseModel::all();
        $attendance = AttendanceModel::orderBy('id', 'DESC')->get();
        $events = EventModel::select('t_events.id as eid', 't_events.*', 't_courses.*')
            ->join('t_courses', 't_courses.id', 't_events.event_course')
            ->get();

        return view('reports.index')->with([
            'events' => $events,
            'courses' => $courseData,
            'course_info' => 'Filter Courses',
            'attendance' => $attendance,
            'attendance_info' => 'Filter Events'
        ]);
    }

    public function filter($id)
    {
        $x = $id;
        $x == 255 ? $x = '%' : $x = $id;

        $courseData = CourseModel::all();
        $courseData_info = CourseModel::where('id', $id)->first();
        $events = EventModel::select('t_events.id as eid', 't_events.*', 't_courses.*')
            ->join('t_courses', 't_courses.id', 't_events.event_course')
            ->where('event_course', 'LIKE', $x)
            ->get();
        $attendance = AttendanceModel::orderBy('id', 'DESC')->get();
        return view('reports.index')->with([
            'events' => $events,
            'courses' => $courseData,
            'course_info' => $courseData_info->course_name,
            'attendance' => $attendance,
            'attendance_info' => 'Filter Events'
        ]);
    }

    public function events($id)
    {
        $x = $id;
        $x == 255 ? $x = '%' : $x = $id;

        $courseData = CourseModel::all();
        $courseData_info = CourseModel::where('id', $id)->first();
        $events = EventModel::select('t_events.id as eid', 't_events.*', 't_courses.*')
            ->join('t_courses', 't_courses.id', 't_events.event_course')
            ->get();
        $attendance = AttendanceModel::where('attend_event_id', $id)->orderBy('id', 'DESC')->get();
        $attendance_info = EventModel::where('id', $id)->first();
        return view('reports.index')->with([
            'events' => $events,
            'courses' => $courseData,
            'course_info' => 'Filter Courses',
            'attendance' => $attendance,
            'attendance_info' => $attendance_info->event_name
        ]);
    }

    public function dashboard()
    {
        $id = session('course_id');
        $courseData = CourseModel::all();
        $attendance = AttendanceModel::orderBy('id', 'DESC')->get();
        $events = EventModel::select('t_events.id as eid', 't_events.*', 't_courses.*')
            ->join('t_courses', 't_courses.id', 't_events.event_course')
            ->get();
        $assign = AssignedModel::all();
        return view('dashboard')->with([
            'events' => $events,
            'courses' => $courseData,
            'course_info' => 'Filter Courses',
            'attendance' => $attendance,
            'attendance_info' => 'Filter Events',
            'assign' => $assign 
        ]);
    }
}
