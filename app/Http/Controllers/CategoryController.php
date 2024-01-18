<?php

namespace App\Http\Controllers;

use App\Models\Category;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
 
    public function index() 
    {
        $categorys=Category::paginate(10);
     
     return response()->json([
        $categorys,200
     ]);
    }

    public function show($category)
    {
        $category=Category::find($category);

        if (!$category){
            return response()->json([
               'message'=>"Category not found"
             ],404);
        }

        return response()->json([
          'category'=>$category
         ],200);
    }

    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'name'=>'required|unique:categories,name',
            'image'=>'required|image',
        ]);

        if ($validator -> fails()){
            return response()->json([
               'message'=>$validator->errors(),
             ]);
        }

        $category=new Category();
        $category->name=$request->name;

        //image upload
        $imagePath='uploads/category';
        if ($request->hasFile('image')){
            $file=$request->file('image');
            $ext=$file->getClientOriginalExtension();
            $filename=time().'.'.$ext;
            $file->move($imagePath,$filename);

            $category->image=$filename;


        }
        $category->save();

        return response()->json([
            'message'=>'Category added successfully.',
            'brand'=>$category,
         ]);
    }

    public function update(Request $request,Category $category)
    {
        $validator=Validator::make($request->all(),[
            'name'=>'required',
        ]);

        if ($validator -> fails()){
            return response()->json([
               'message'=>$validator->errors(),
             ]);
        }

        $category->name=$request->name;

        //image upload
        $imagePath='uploads/category';

        if ($request->hasFile('image')){
            $path='uploads/category'.$category->image;
            //delete old
            if (File::exists($path)){
                File::delete($path);
            }

            $file=$request->file('image');
            $ext= $file->getClientOriginalExtension();
            $filename=time().'.'.$ext;
            $file->move($imagePath,$filename);
            $category->image=$filename;
        }
        $category->save();
        return response()->json([
            'message'=>'Category updated successfully.',
            'brand'=>$category,
         ],201);
    }

    public function destroy($category)
    {
        $brand=Category::find($category);
        $brand->delete();
        if (!$category
        ){
            return response()->json([
                'message'=>'Category not found.',
             ],404);
        }
        return response()->json([
            'message'=>'Category deleted sucessfully.',
         ],404);

    }
}



