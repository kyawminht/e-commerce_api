<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Validator;

class BrandController extends Controller
{
    public function index() 
    {
     $brands=Brand::paginate(10);
     
     return response()->json([
        $brands,200
     ]);
    }

    public function show($brand)
    {
        $brand=Brand::find($brand);

        if (!$brand){
            return response()->json([
               'message'=>"Brand not found"
             ],404);
        }

        return response()->json([
          'brand'=>$brand
         ],200);
    }

    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'name'=>'required|unique:brands,name',
        ]);

        if ($validator -> fails()){
            return response()->json([
               'message'=>$validator->errors(),
             ]);
        }

        $brand=new Brand();
        $brand->name=$request->name;
        $brand->save();

        return response()->json([
            'message'=>'Brand added successfully.',
            'brand'=>$brand,
         ]);
    }

    public function update(Request $request,Brand $brand)
    {
        $validator=Validator::make($request->all(),[
            'name'=>'required',
        ]);

        if ($validator -> fails()){
            return response()->json([
               'message'=>$validator->errors(),
             ]);
        }

        
        $brand->name=$request->name;
        $brand->save();

        return response()->json([
            'message'=>'Brand updated successfully.',
            'brand'=>$brand,
         ],201);
    }

    public function destroy($brand)
    {
        $brand=Brand::find($brand);
        $brand->delete();
        if (!$brand){
            return response()->json([
                'message'=>'Brand not found.',
             ],404);
        }
        return response()->json([
            'message'=>'Brand deleted sucessfully.',
         ],404);

    }
}
