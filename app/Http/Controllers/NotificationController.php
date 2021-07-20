<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function send(Request $request){
        return $this->sendNotification($request->device_token, array(
            "title" => "Sample Message",
            "body" => "bonk bonk bonk"
        ));
    }



    public function sendNotification($device_token, $message){

        $SERVER_API_KEY = "AAAA8YGaimA:APA91bGJGdKQbFOnAKoX5JuHGWjKIKg73f5fpzwXHIs0Hxyxf8VlqIEDlf9X-sdtCLgwca8TcWZvflvc84cG5VbFyQ7Hk1ED8lYy99WHqjvXNHQORkoAk-4pGFgDuV98tfrchV8cuurn";

        $data = [
            "to" => 'dYzDsy7FTnGiZzoSs7BPg1:APA91bHciGZzC3eDJRoYZyOYZxgn9R4CXZBBJl3nSEcJ0do6zeiw_D-JTlcl9xDph1Lw322S8j-vkq2wNuJkYXP5KKxcgames-XXOH5z0l8Dfg4kLpBnzVOYpe5SLegAi6h18SzMfSES',
            "data" => $message
        ];

        $dataString = \json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = \curl_init();
        \curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        \curl_setopt($ch, CURLOPT_POST, true);
        \curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        \curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        \curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        \curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}
