<?php


use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

use App\Models\AttendanceModel;
use App\Models\InchargeModel;
use App\Models\AssignedModel;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

route::post('/details', function(Request $request){
    $id = $request->input('id');
    $data = AssignedModel::join('t_courses', 't_courses.id', 't_assign.course_id')->where('student_id', $id)->first();
    return response()->json($data);
});

route::post('/delete', function(Request $request){
    $id = $request->input('id');
    $data = AssignedModel::where('student_id', $id)->delete();
    return response()->json($data);
});

route::post('/update', function(Request $request){
    $id = $request->input('id');
    date_default_timezone_set('Asia/Manila');
    $data = AssignedModel::where('student_id', $id)->update(['assign_type' => $request->input('type')]);
    return response()->json($data);
});

route::post('/save', function (Request $request) {

    
    date_default_timezone_set('Asia/Manila');
    
    $rules = [
        'id' => 'required|integer',
        'name' => 'required|string|max:255',
        'status' => 'required|string|in:Check-In,Check-Out',
        'event' => 'required|integer|exists:t_events,id'
    ];

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->errors()
        ], 422);
    }


    $status = $request->input('status');
    $event_id = $request->input('event');
    $student_id = $request->input('id');
    $student_name = $request->input('name');

    $current_date = now()->format('Y-m-d');
    $current_time = now()->format('H:i:s');
    $timestamp = $current_date . ' ' . $current_time;

    $start_of_day = $current_date . ' 00:00:00';
    $end_of_day = $current_date . ' 23:59:59';

    $check_exist =  AttendanceModel::where('attend_student_id', $student_id)
        ->where('attend_event_id', $event_id)
        ->whereBetween('attend_checked_in_at', [$start_of_day, $end_of_day])
        ->count();

    if ($status == 'Check-In') {

        if ($check_exist == 1) {
            return response()->json([
                'message' => 'Student is Already Check-In',
                'content' => 'The student Check-In attendance is already exist.',
                'status' => 'warning'
            ]);
        }

        AttendanceModel::create([
            'attend_event_id' => $event_id,
            'attend_student_id' => $student_id,
            'attend_student_name' => $student_name,
            'attend_checked_in_at' => $timestamp
        ]);

        return response()->json([
            'message' => 'Check-In Successful',
            'content' => 'The student Check-In attendance has been recorded.',
            'status' => 'success'
        ]);
    } elseif ($status == 'Check-Out') {

        if ($check_exist == 0) {
            return response()->json([
                'message' => 'No Check-In Attendance',
                'content' => 'The student has No Check-In attendance.',
                'status' => 'error'
            ]);
        }

        $event = AttendanceModel::where('attend_event_id', $event_id)
            ->whereBetween('attend_checked_in_at', [$start_of_day, $end_of_day])
            ->where('attend_checked_out_at', null)
            ->first();

        if ($event) {
            $event->update([
                'attend_checked_out_at' => $timestamp
            ]);


            return response()->json([
                'message' => 'Check-Out Successful',
                'content' => 'The student Check-Out attendance has been recorded.',
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'message' => 'Student is Already Check-Out',
                'content' => 'The student Check-Out Attedance is already exist.',
                'status' => 'error'
            ]);
        }
    }

    return response()->json(['message' => 'Operation successful']);
});

route::post('/search', function (Request $request) {

    $studentId = $request->input('id');

    $searchData = [
        'id' => $studentId,
    ];

    $token = $request->input('token');;


    if (!$token) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    $response = Http::withToken($token)->withOptions([
        'verify' => false,
    ])->post('https://auth.mserv.online/index.php/api/get-info', $searchData);

    if ($response->successful()) {
        return response()->json($response->json());
    } else {
        return response()->json(['message' => 'Unauthorized or invalid request'], $response->status());
    }
});
