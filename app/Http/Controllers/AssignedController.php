<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Courses;

use App\Models\EventModel;
use App\Models\AssignedModel;
use App\Models\CourseModel;


class AssignedController extends Controller
{


    public function index(){
        $assign = AssignedModel::join('t_courses', 't_courses.id', 't_assign.course_id')
            ->get();

       return view('assign.index')->with([
            'assign' => $assign
        ]);
    }

    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Manila');

        $request->validate(rules: [
            'inp_sid' => 'required|integer',
            'inp_name' => 'required|string',
            'inp_course' => 'required|integer',
            'inp_assign' => 'required|string',
        ]);

        $builder = new AssignedModel([
            'student_id' => $request->input('inp_sid'),
            'student_name' => $request->input('inp_name'),
            'course_id' => $request->input('inp_course'),
            'assign_type' => $request->input('inp_assign'),
        ]);

        $builder->save();

        return redirect()->back()->with('success', 'New Event has been added!');
    }
}
