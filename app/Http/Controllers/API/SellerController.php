<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginSellerRequest;
use App\Http\Requests\RegisterSellerRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use App\Models\Seller;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    //create seller or register seller
    public function register(RegisterSellerRequest $request)
    {
       $seller = Seller::query()->create([
            'name' =>$request->name,
            'email' => $request->email,
            'password' =>Hash::make($request->password),
            'address' =>$request->address,
            'contact_no' =>$request->address
        ]);

        //generate token using laravel santcum package

        $token = $seller->createToken('marketplacetoken')->plainTextToken;

        $response =[
            'seller' =>$seller,
            'token'  =>$token
        ];

        return response($response, Response::HTTP_CREATED);
    }

    //seller login 

    public function login(LoginSellerRequest $request) {
        
        // Check email of seller
        $seller = Seller::query()->where('email', $request->email)->first();

        // Check password of seller
        if(!$seller || !Hash::check($request->password, $seller->password)) {
            return response([
                'message' => 'Credential Not Matched'
            ], Response::HTTP_UNAUTHORIZED);
        }

        //generate token using laravel santcum package

        $token = $seller->createToken('marketplacetoken')->plainTextToken;

        $response = [
            'seller' => $seller,
            'token' => $token
        ];

        return response($response, Response::HTTP_CREATED);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return [
            'message' => 'Logged out Succssfully !!'
        ];
    }
}
