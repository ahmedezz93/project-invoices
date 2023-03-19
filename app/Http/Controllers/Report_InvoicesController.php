<?php

namespace App\Http\Controllers;

 use Illuminate\Http\Request;
 use App\Models\invoice;
class Report_InvoicesController extends Controller
{
    

public function index(){


return view("reports.invoices_reports");

}



public function invoice_search(Request $request){

$rdio=$request->rdio;

if($rdio==1){

$invoice_type=$request->type;
$start_at=$request->start_at;
$end_at=$request->end_at;



if( $invoice_type &&$start_at== "" && $end_at=="" ){


$invoices=invoice::where("status",$invoice_type)->get();

return view("reports.invoices_reports",compact('invoices'));

}

elseif( $invoice_type && $start_at && $end_at ){


$invoices=invoice::whereBetween("invoice_date",[$start_at,$end_at])->where("status",$invoice_type)->get();

return view("reports.invoices_reports",compact('invoices'));

}

}

elseif($rdio==2){

$invoices=invoice::where("invoice_number",$request->invoice_number)->get();
return view("reports.invoices_reports",compact('invoices'));

}


}

}
