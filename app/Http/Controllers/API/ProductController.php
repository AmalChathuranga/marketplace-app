<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    //get all products
    public function index():Response
    {
        $products = Product::query()->get();
        return response()->json(['data'=>$products ,'status'=> Response::HTTP_CREATED]);
    
    }

    //store product
    public function store( StoreProductRequest $request)
    {

       // $image_path = $request->file('image')->store('image', 'public');
        $data = Product::query()->create([
            'name' =>$request->name,
            'slug'  =>$request->slug,
            'description' =>$request->description,
            'price' => $request->price,
            //'image' => $image_path,
            'quantity' => $request->quantity,
        ]);

        return response()->json(['data'=>$data ,'status'=> Response::HTTP_CREATED]);
    }

    //get single products

    public function show(Product $product) :Response
    {
        return response()->json(['data'=>$product ,'status'=> Response::HTTP_CREATED]);
    }

    //update product

    public function update(Request $request, Product $product) :Response
    {
        
        $product->query()->update([
            'name' =>$request->name ?? $product->name,
            'slug'  =>$request->slug ?? $product->slug,
            'description' =>$request->description,
            'price' => $request->price ?? $product->price,
            'quantity' => $request->quantity ?? $product->quantity,
        ]);

        return response()->json(['data'=>$product ,'status'=> Response::HTTP_CREATED]);
    }

    //get product by seller
    public function getProductSellers($id)
    {
        $product =Product::findOrFail($id);
        $sellers = $product->sellers;
        $data =[];
        foreach($sellers as $key =>$value)
        {
            $data[$key] =[
                'seller_id' => $value->id,
                'seller_name' =>$value->name,
                'quantity' => $value->pivot->quantity,
            ];
        }
        return response()->json(['data'=>$data ,'status'=> Response::HTTP_CREATED]);
    }
}
