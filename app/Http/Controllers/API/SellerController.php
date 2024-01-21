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
        $token = self::generateToken($seller);
        $response =[
            'seller' =>$seller,
            'token'  =>$token
        ];

        return response()->json(['data'=>$response ,'status'=> Response::HTTP_CREATED]);
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

        $token = self::generateToken($seller);
        $response = [
            'seller' => $seller,
            'token' => $token
        ];

          return response()->json(['data'=>$response ,'status'=> Response::HTTP_CREATED]);
    }

    //generate token
    public function generateToken($data)
    {
        //generate token using laravel santcum package
        $token = $data->createToken('marketplacetoken')->plainTextToken;
        return $token;
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return response()->json(['message'=>'user logout successfully' ,'status'=> Response::HTTP_CREATED]);
    }

    

    public function storeSellerProducts(Request $request)
    {
      
        //product array
        $products =[ 5 => ['quantity' => 40], 3 => ['quantity' => 100]];
        $seller = self::getSeller();
        $seller->products()->attach($products);
        return response()->json(['message'=>'product added sucessfully' ,'status'=> Response::HTTP_CREATED]);

    }

//get product list by seller
    public function getSellerProductList()
    {
        $seller = self::getSeller();
        $products =$seller->products;
        $data =[];
        foreach($products as $key =>$value)
        {
            $data[$key] =[
                'product_id' => $value->id,
                'product_name' =>$value->name,
                'quantity'    =>$value->pivot->quantity,
            ];
        }
        return response()->json(['data'=>$data ,'status'=> Response::HTTP_CREATED]);
    }

    //get auth seller details
    public function getSeller()
    {
        $id = auth()->user()->id;
        $seller = Seller::findOrFail($id);
        return $seller;
    }
}
