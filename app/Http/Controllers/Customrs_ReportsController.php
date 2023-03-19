<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\invoice;
use App\Models\product;
use App\Models\section;

class Customrs_ReportsController extends Controller
{
    

public function index(){
    
    $sections=section::all();

return view('reports.customers_reports',compact('sections'));

}



public function get_product($id){


$products=product::where('section_name',$id)->pluck("name","id");

return json_encode($products);


}


public function search_customers_reports(Request $request){
$validate=$request->validate([

"section"=>"required",
],[

"section.required"=>"يرجى ادخال القسم المطلوب",
]
);

$section=$request->section;
$start_at=$request->start_at;
$end_at=$request->end_at;

if($section && $start_at=="" && $end_at==""){
    

$invoices=invoice::where("section_name",$section)->get();
$sections=section::all();
return view("reports.customers_reports",compact("invoices",'sections'));


}
elseif($section && $start_at && $end_at){


    $invoices=invoice::wherebetween("invoice_date",[$start_at,$end_at])->where("section_name",$section)->get();
    $sections=section::all();
    return view("reports.customers_reports",compact("invoices",'sections'));


}
}
}
