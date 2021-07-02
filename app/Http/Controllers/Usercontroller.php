
<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $product)
    {
        //Validate data
        $data = $request->only('name', 'sku', 'price', 'quantity');
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'sku' => 'required',
            'price' => 'required',
            'quantity' => 'required'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is valid, update product
        $product = $product->update([
            'name' => $request->name,
            'sku' => $request->sku,
            'price' => $request->price,
            'quantity' => $request->quantity
        ]);

        //Product updated, return success response
        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'data' => $product
        ], Response::HTTP_OK);
    }

    public function getContactInfo($id){
        $contactUser = \App\Models\User::find($id);
        
        $contactInfo = [
            'naam' => $contactUser->name,
            'publieke_email' => $contactUser->publieke_email,
            'telefoonnummer' => $contactUser->telefoonnummer,
            'twitter' => $contactUser->twitter,
            'facebook' => $contactUser->facebook,
            'snapchat' => $contactUser->snapchat,
            'instagram' => $contactUser->instagram,
            'linkedin' => $contactUser->linkedin,
            'tiktok' => $contactUser->tiktok,
            'geboortedatum' => $contactUser->geboortedatum,
            'adres' => $contactUser->adres,
            'woonplaats' => $contactUser->woonplaats,
            'postcode' => $contactUser->postcode,
            'land' => $contactUser->land,
        ];

        return response()->json(['contactInfo' => 'test'], 200);
    }


}
