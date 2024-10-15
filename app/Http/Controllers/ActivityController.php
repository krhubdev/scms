<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\CourseModel;
use App\Models\EventModel;


class ActivityController extends Controller
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

        return view('activities.index')->with([
            'events' => $events,
            'courses' => $courseData
        ]);
    }

    public function filter($id)
    {   
        $x = $id;
        $x == 255 ? $x = '%' : $x = $id;

        $courseData = CourseModel::all();
        $events = EventModel::select('t_events.id as eid', 't_events.*', 't_courses.*')
            ->join('t_courses', 't_courses.id', 't_events.event_course')
            ->where('event_course', 'LIKE', $x)
            ->get();

        return view('activities.index')->with([
            'events' => $events,
            'courses' => $courseData
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
