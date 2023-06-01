<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TrackingController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            // Process the form submission and retrieve the tracking code
            $trackingCode = $request->input('tracking_code');

            // Perform the necessary actions with the tracking code (e.g., call the tracking API)

            // Make a request to the API
            $response = Http::post('https://api.17track.net/track/v2/register', [
                [
                    'number' => $trackingCode
                ]
            ], [
                'headers' => [
                    'Content-Type' => 'application/json',
                    '17token' => '960CA011F69EFD23C75D9E2B01F9E5BE'
                ]   
            ]);

            if ($response->successful()) {
                $data = $response->json();

                // Process the API response and extract the necessary data
                
                // Example: Display the tracking results on the page

                dd(['trackingCode' => $trackingCode, 'trackingData' => $data]);
                return view('tracking.index', ['trackingCode' => $trackingCode, 'trackingData' => $data]);
            } else {
                // Handle the error response
                $error = $response->json();
                
                // Example: Display an error message

                dd(['trackingCode' => $trackingCode, 'error' => $error]);

                return view('tracking.index', ['trackingCode' => $trackingCode, 'error' => $error]);
            }
        }

        return view('tracking.index' , ['trackingCode' => null, 'error' => null]);
    }

    public function fetchTrackingData()
    {
        // Make a GET request to the Node.js app's endpoint
        $response = Http::get('https://app-proxy-17track-nodejs.onrender.com/tracking-data');
        
        if ($response->successful()) {
            // Retrieve the tracking data from the response
            $trackingData = $response->json();
            
            // Process the tracking data and display it in your application's UI
            
            // Return a response or perform any other necessary actions
            return response()->json(['success' => true, 'trackingData' => $trackingData]);
        } else {
            // Handle the error response
            $error = $response->json();
            
            // Return an error response or perform any other necessary actions
            return response()->json(['success' => false, 'error' => $error], $response->status());
        }
    }
}