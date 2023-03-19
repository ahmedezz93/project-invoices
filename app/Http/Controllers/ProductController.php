<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\section;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections=section::all();
        $products=product::all();
         return view('products.products',compact('sections','products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     $validate=$request->validate([

         "product_name"=>"required|max:255",
         "description"=>"required|max:255",
         "section_name"=>"required",
         ],[
             "product_name.required"=>"هذا الحقل(الاسم) مطلوب",
         "product_name.max:255"=>"عدد احرف حقل الاسم اكثر من 255",

         "description.required"=>"حقل الوصف مطلوب",
         "product_description.max:255"=>"عدد احرف حقل الوصف اكثر من 255",
         "section_name.required"=>"يرجي ادخال القسم",
     ]);



$products=product::create([
    "name"=>$request->product_name,
        "description"=>$request->description,
        "section_name"=>$request->section_name,
]);
        session()->flash('add',"لقد تم اضافه القسم بنجاح");
return back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(product $product)
    {
        //
    }
}
