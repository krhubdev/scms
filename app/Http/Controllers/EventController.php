<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Courses;

use App\Models\EventModel;
use App\Models\CourseModel;


class EventController extends Controller
{


    public function index(){
        $events = EventModel::get();

        $courses = new Courses();
        $courseData = CourseModel::all();

       return view('ssc.index')->with([
            'events' => $events,
            'courses' => $courseData
        ]);
    }

    public function store(Request $request)
    {
        $request->validate(rules: [
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
