<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    use HasFactory;

    public function getCourses()
    {
        $url = "https://auth.mserv.online/index.php/api/courses";

        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        
        // Optional: If you need to disable SSL verification (not recommended for production)
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Execute the request
        $response = curl_exec($ch);

        // Check for errors
        if (curl_errno($ch)) {
            // Handle the error, optionally throw an exception
            throw new \Exception('cURL Error: ' . curl_error($ch));
        }

        curl_close($ch);

        // Decode and return the JSON response
        return json_decode($response, true);
    }
}
