<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
// composer require simplesoftwareio/simple-qrcode

use App\Models\EventModel;
use App\Models\AttendanceModel;
use App\Models\CourseModel;
use App\Models\FeedbackModel;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        $sid = session('student_id');
        // Validate the inputs
        $request->validate([
            'review' => 'required|string',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:12048', // Max size 2MB per image
        ]);

        // Initialize an array to store the filenames
        $fileNames = [];

        // Handle file uploads
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                // Define a unique name for each file
                $fileName = time() . '_' . $photo->getClientOriginalName();
                
                // Move the file to a specific directory
                $directory = 'uploads/photos';
                $photo->move(public_path($directory), $fileName);

                // Push the file name to the array
                $fileNames[] = $fileName;
            }
        }

        // Save feedback to the t_feedbacks table
        FeedbackModel::create([
            'event_id' => $request->input('event_id'),   // Assuming event_id is passed
            'student_id' => $sid, // Assuming student_id is passed
            'directory' => 'uploads/photos',    // The directory where the files are saved
            'file_names' => json_encode($fileNames), // Store filenames as JSON
        ]);

        //return redirect()->back();

       return redirect()->back()->with('success', 'Feedback and photos uploaded successfully.');
    }

}
