<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{

    public function register(Request $request)
    {
    	//Validate data
        $data = $request->only('name', 'email', 'password');
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|max:50',
            'fcmtoken' => 'string'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is valid, create new user
        $user = User::create([
            'device_id' => $request->fcmtoken,
        	'name' => $request->name,
        	'email' => $request->email,
        	'password' => bcrypt($request->password)
        ]);

        //User created, return success response
        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'data' => $user
        ], Response::HTTP_OK);
    }


    public function sendNotification($user){

        $aangepasteUserId = $user->id;
        $aangepasteUserNaam = $user->name;
        $contactsToBeNotified = Contact::where('contactId', '==', $aangepasteUserId);

        $fcmTokens = Array();
        
        foreach($contactsToBeNotified as $contactToBeNotified){
            $userToBeNotified = User::find($contactToBeNotified->ownerId);
            array_push($fcmTokensfrom_usersTobeNotified, $userToBeNotified->device_id);
        }

        $allUsers = User::all();
        foreach($allUsers as $singleUser){
            $contacts = $singleUser->myContacts;

            foreach($contacts as $contact){
                if($contact->contactId == $aangepasteUserId){
                    array_push($fcmTokens, $singleUser->device_id);
                }
            }
        }
        //code om push notificatie te verzenden via CURL en Firebase (https://onlinewebtutorblog.com/laravel-8-send-push-notification-to-android-using-firebase/)
        $SERVER_API_KEY = "AAAA8YGaimA:APA91bGJGdKQbFOnAKoX5JuHGWjKIKg73f5fpzwXHIs0Hxyxf8VlqIEDlf9X-sdtCLgwca8TcWZvflvc84cG5VbFyQ7Hk1ED8lYy99WHqjvXNHQORkoAk-4pGFgDuV98tfrchV8cuurn";
        $data = [
            "registration_ids" => $fcmTokens,
            "data" => array(
                "title" => "Contact update:",
                "body" => $aangepasteUserNaam . " heeft hun gegevens aangepast!",
                "contact" => $aangepasteUserNaam
            )
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



    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        //valid credential
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is validated
        //Crean token
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                	'success' => false,
                	'message' => 'Login credentials are invalid.',
                ], 400);
            }
        } catch (JWTException $e) {
    	return $credentials;
            return response()->json([
                	'success' => false,
                	'message' => 'Could not create token.',
                ], 500);
        }

        $user = JWTAuth::user();
        $user->device_id = $request->fcmtoken;
        $user->save();

 		//Token created, return with success response and jwt token
        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => $user
        ]);

    }

    public function logout(Request $request)
    {
        //valid credential
        $validator = Validator::make($request->only('token'), [
            'token' => 'required'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

		//Request is validated, do logout
        try {
            $user = JWTAuth::user();
            $user->device_id = null;
            $user->save();
            JWTAuth::invalidate($request->token);

            return response()->json([
                'success' => true,
                'message' => 'User has been logged out'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, user cannot be logged out'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function get_userInfo(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);

        $user = JWTAuth::authenticate($request->token);

        return response()->json(['user' => $user]);
    }

    public function get_user(Request $request, $userId) {
        $user = User::find($userId);
        return response()->json(['user' => $user]);
    }

    public function update(Request $request) {
        $data = $request->only('token');
        $validator = Validator::make($data, [
            'token' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'succes' => false,
                'error' => $validator->messages()
            ], 200);
        }

        $user = JWTAuth::authenticate($request->token);

        if($request->name != ''){
            $user->name = $request->name;
        }
        if($request->email != ''){
            $user->email = $request->email;
        }
        if($request->public_email != ''){
            $user->public_email = $request->public_email;
        }
        if($request->telefoonnummer != ''){
            $user->telefoonnummer = $request->telefoonnummer;
        }
        if($request->twitter != ''){
            $user->twitter = $request->twitter;
        }
        if($request->facebook != ''){
            $user->facebook = $request->facebook;
        }
        if($request->snapchat != ''){
            $user->snapchat = $request->snapchat;
        }
        if($request->instagram != ''){
            $user->instagram = $request->instagram;
        }
        if($request->linkedin != ''){
            $user->linkedin = $request->linkedin;
        }
        if($request->tiktok != ''){
            $user->tiktok = $request->tiktok;
        }
        if($request->geboortedatum != ''){
            $user->geboortedatum = $request->geboortedatum;
        }

        
    
        try {
            $user->save();
            $this->sendNotification($user);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e,
            ]);
        }


        return response()->json([
            'success' => true,
            'message' => 'Gebruiker is geupdated',
            'request' => $user,
            'date' => $request->geboortedatum
        ], Response::HTTP_OK);
    }


    public function insertNewContact(Request $request){
        $data = $request->only('token');
        $validator = Validator::make($data, [
            'token' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'succes' => false,
                'error' => $validator->messages()
            ], 200);
        };

        $user = JWTAuth::authenticate($request->token);
        $userId = $user->id;
        $contactId = User::find($request->contactId);
        
        $contact = Contact::create([
            'ownerId' => $userId,
            'contactId' => $contactId->id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Contact added succesfully',
            'data' => $contact
        ], Response::HTTP_OK);
    }

    public function getMyContacts(Request $request){
        $data = $request->only('token');
        $validator = Validator::make($data, [
            'token' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'succes' => false,
                'error' => $validator->messages()
            ], 200);
        };

        $user = JWTAuth::authenticate($request->token);
        $contacts = $user->myContacts;

        $contactsInfoArray = [];

        foreach($contacts as $contact){
            $contactToBeRetrieved = User::find($contact->contactId);
            $contactObject = (object) [
                'id' => $contactToBeRetrieved->id,
                'name' => $contactToBeRetrieved->name,
                'public_email' => $contactToBeRetrieved->public_email,
                'telefoonnummer' => $contactToBeRetrieved->telefoonnummer,
                'twitter' => $contactToBeRetrieved->twitter,
                'facebook' => $contactToBeRetrieved->facebook,
                'snapchat' => $contactToBeRetrieved->snapchat,
                'instagram' => $contactToBeRetrieved->instagram,
                'linkedin' => $contactToBeRetrieved->linkedin,
                'tiktok' => $contactToBeRetrieved->tiktok,
                'geboortedatum' => $contactToBeRetrieved->geboortedatum,
            ];

            array_push($contactsInfoArray, $contactObject);
        }

        return response()->json([
            'success' => true,
            'message' => 'Contacts retrieved succesfully',
            'data' => $contactsInfoArray
        ], Response::HTTP_OK);
          
    }

    
    
}
