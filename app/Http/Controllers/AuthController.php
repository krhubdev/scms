<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\AssignedModel;


class AuthController extends Controller
{
    public function index(Request $request)
    {
        $session = session('access_token');
        if ($session) {
            return redirect('/auth/progress');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {

        if (Auth::attempt(['email' => $request->input('username'), 'password' => $request->input('password')])) {
            $request->session()->regenerate();

            $credentials_config = [
                'client_key' => env('MSERV_CLIENT_KEY'),
                'username' => env('MSERV_USERNAME'),
                'password' => env('MSERV_PASSWORD'),
            ];

            $response = Http::withOptions([
                'verify' => false,
            ])->post('https://auth.mserv.online/index.php/api/auth', $credentials_config);

            if ($response->successful()) {
                $json = $response->json();
                if (!isset($json['access_token']) || is_null($json['access_token'])) {
                    return redirect()->back()->with(['message' => 'Login failed']);
                }
                session(['access_token' => $response->json()['access_token']]);
               return redirect('/auth/progress');
            } else {
                return redirect()->back()->with(['message' => 'Login failed']);
            }
        }

        $credentials = [
            'client_key' => env('MSERV_CLIENT_KEY'),
            'username' => $request->input('username'),
            'password' => $request->input('password'),
        ];

        $response = Http::withOptions([
            'verify' => false,
        ])->post('https://auth.mserv.online/index.php/api/login', $credentials);

        if ($response->successful()) {
            $json = $response->json();
            if (!isset($json[0]['access_token']) || is_null($json[0]['access_token'])) {
                return redirect()->back()->with(['message' => 'Login failed']);
            }
            session(['access_token' => $response->json()[0]['access_token']]);
            session(['course_id' => $response->json()['course']]);
            session(['student_id' => $response->json()['student_id']]);
            session(['student_name' => $response->json()['student_name']]);
            session(['student_course' => $response->json()['student_course']]);
            session(['student_year_level' => $response->json()['student_year_level']]);

            return redirect('/auth/progress');
        } else {
            return redirect()->back()->with(['message' => 'Login failed']);
        }
    }

    public function logout()
    {
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/');
    }

    public function progress()
    {
        $id = session('student_id');
        $check = AssignedModel::where('student_id', $id)->first();
        if ($check) {
            session(['student_assign' => $check->assign_type]);
            return redirect('/dashboard');   
        } else {
            session(['student_assign' => '']);
            return redirect('/student/activity');   
        }
    }

    public function updatePassword(Request $request)
    {
        $messages = [
            'inp_rp.same' => 'The Repeat Password does not match the New Password.',
            'inp_np.same' => 'The New Password does not match the NRepeatew Password.',
        ];

        // Validate the form data
        $request->validate([
            'inp_cp' => 'required|string',
            'inp_np' => 'required|string|min:8',
            'inp_rp' => 'required|string|same:inp_np',
        ], $messages);

        // Get the current authenticated user
        $user = Auth::user();

        // Check if the current password is correct
        if (!Hash::check($request->inp_cp, $user->password)) {
            return back()->withErrors(['inp_cp' => 'Current password is incorrect']);
        }

        // Update the user's password
        $user->password = Hash::make($request->inp_np);
        $user->save();

        // Return a success message
        return back()->with('success', 'Password updated successfully!');
    }

}
