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
            "to" => 'eXZcusjfSxCCW1LzbFV1Hj:APA91bGZdi1QxVxLijI-tSeVxsP5Gr99xCjA-PrlmVab5hy4oRASZUl3dZQBuW9hZ8bCpWndbfQk40re4QYtmOrvyToh7aIwe-ltmeBY0x8z3rTvlsP11Zt2FUKlaLFV61CQhdbDvXnY',
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
