<?php

namespace App\Http\Controllers;
use App\Exports\InvoiceExport;
use App\Models\invoice;
use App\Models\User;
use App\Models\product;
use App\Models\section;
use App\Notifications\CreatInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Notification;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices=invoice::all();
return view('invoices.invoices',compact('invoices'));
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
        $validation=$request->validate([
            "invoice_number"=>"required|unique:invoices,invoice_number",
              "invoice_Date"=>"required",
            "Due_date"=>"required",
            "Section"=>"required",
           "product"=>"required",
           "Discount"=>"required",
            "Amount_Commission"=>"required",
            "Rate_VAT"=>"required",
            "amount_collection"=>"required",
        ],[
            "invoice_number.required"=>"يرجى ادخال رقم الفاتورة",
            "Due_date.required"=>"يرجى ادخال تاريخ الاستحقاق",
            "invoice_number.unique"=>"رقم الفاتوره موجود مسبقا يرجي ادخال رقم جديد",
            "invoice_Date.required"=>"يرجي ادخال تاريخ الفاتورة",
            "Section.required"=>"يرجي ادخال القسم",
            "product.required"=>"يرجي ادخال المنتج",
            "Discount.required"=>"يرجى ادخال مبلغ الخصم",
            "Amount_Commission.required"=>"يرجى ادخال مبلغ العمولة",
        "Rate_VAT.required"=>"يرجي ادخال نسبة الضريبة",
        "amount_collection.required"=>"يرجى ادخال مبلغ التحصيل",
        ]);

        $invoices=invoice::create([
            "invoice_number"=>$request->invoice_number,
            "invoice_date"=>$request->invoice_Date,
            "due_date"=>$request->Due_date,
            "section_name"=>$request->Section,
            "product"=>$request->product,
            "amount_collection"=>$request->amount_collection,
            "amount_commission"=>$request->Amount_Commission,
            "discount"=>$request->Discount,
            "rate_vate"=>$request->Rate_VAT,
            "value_vate"=>$request->Value_VAT,
            "total"=>$request->Total,
            "status"=>"غير مدفوعة",
            "status_value"=>2,
            "user"=>Auth::user()->name,
            "notes"=>$request->note,
        ]);

$users=user::where("id","!=",Auth::user()->id)->get();
$create_user=Auth::user()->name;
$invoice_id=$invoices->latest()->first()->id;
$invoices_number=$invoices->latest()->first()->invoice_number;
 Notification::send($users,new CreatInvoice($create_user,$invoices_number,$invoice_id));


 session()->flash('add',"تم اضافة الفاتورة بنجاح");

return back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
               
        $sections=section::all();
      $invoice=invoice::where("id",$id)->first();  
    return view('invoices.edit_invoice',compact('invoice','sections'));
    
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $id=$request->id;

        //التحقق من الحقول
        $validation=$request->validate([
            "invoice_number"=>"required",
              "invoice_Date"=>"required",
            "Due_date"=>"required",
            "Section"=>"required",
           "product"=>"required",
           "Discount"=>"required",
            "Amount_Commission"=>"required",
            "Rate_VAT"=>"required",
            "Amount_collection"=>"required",
        ],[
            "invoice_number.required"=>"يرجى ادخال رقم الفاتورة",
            "Due_date.required"=>"يرجى ادخال تاريخ الاستحقاق",
            "invoice_number.unique"=>"رقم الفاتوره موجود مسبقا يرجي ادخال رقم جديد",
            "invoice_Date.required"=>"يرجي ادخال تاريخ الفاتورة",
            "Section.required"=>"يرجي ادخال القسم",
            "product.required"=>"يرجي ادخال المنتج",
            "Discount.required"=>"يرجى ادخال مبلغ الخصم",
            "Amount_Commission.required"=>"يرجى ادخال مبلغ العمولة",
        "Rate_VAT.required"=>"يرجي ادخال نسبة الضريبة",
        "Amount_collection.required"=>"يرجى ادخال مبلغ التحصيل",
        ]);

//تحديث بيانات الفاتورة

$invoices=invoice::where("id",$id)->update([
                "invoice_number"=>$request->invoice_number,

                "invoice_Date"=>$request->invoice_Date,

                "due_date"=>$request->Due_date,

                "section_name"=>$request->Section,

                "product"=>$request->product,

                "discount"=>$request->Discount,


                "amount_commission"=>$request->Amount_Commission,

                "rate_vate"=>$request->Rate_VAT,

                "amount_collection"=>$request->Amount_collection,

]);
session()->flash('update',"تم تحديث الفاتوره بنجاح");
return back();
   
    }

    public function delete( $id)
    {

     invoice::where('id',$id)->forcedelete();
    session()->flash('delete',"لقد تم حذف الفاتورة بنجاح");
    return back();
}

    public function add_invoice(){
       $products=product::all();
       $sections=section::all();
        return view('invoices.add_invoice',compact('products','sections'));

    }

    public function get_product($id){
        $products=product::where('section_name',$id)->pluck('name','id');
        return json_encode($products);
    }

    
    public function change_payment($id){

          $invoices=invoice::where('id',$id)->first();

          return view('invoices.change_payment',compact('invoices'));

    }

    public function update_payment(Request $request){
       $id=$request->invoice_id;
       $status=$request->Status;
       $date=$request->Payment_Date;


$validated=$request->validate([
"Status"=>"required",
"Payment_Date"=>"required",

],[

    "Status.required"=>"يرجي ادخال حالة الدفع",
    "Payment_Date.required"=>"يرجى ادخال تاريخ الدفع",

]);

if($status==1){

    invoice::where("id",$id)->update([

    "status_value"=>$status,

    "status"=>"مدفوعة",

    "invoice_date"=>$date,

    ]);

     }

     elseif($status==3){

        invoice::where("id",$id)->update([

            "status_value"=>$status,

            "status"=>"مدفوعةجزئيا",

            "invoice_date"=>$date,

                ]);
            
     }       
     
     elseif($status==2){

        invoice::where("id",$id)->update([

            "status_value"=>$status,

            "status"=>"  غير مدفوعة",

            "invoice_date"=>$date,

                ]);
            
     }       


      session()->flash('update',"تم تحديث حاله الفاتورة بنجاح");
      return back();

    }


public function print_invoice($id){
$invoices=invoice::where('id',$id)->first();
return view('invoices.print_invoice',compact('invoices'));


}
public function paid_invoice(){
$invoices=invoice::where("status_value","1")->get();
return view('invoices.invoices_paid',compact('invoices'));

}


public function delete_paid_invoice(Request $request){

invoice::where("id",$request->id)->forcedelete();
session()->flash("delete","تم حذف الفاتورة بنجاح");
return back();

}


public function unpaid_invoice(){

$invoices=invoice::where("status_value","2")->get();
return view('invoices.invoices_unpaid',compact("invoices"));


}


public function partial_paid__invoice(){

    $invoices=invoice::where("status_value","3")->get();
    return view('invoices.invoices_Partial',compact("invoices"));
    
    
}

public function export() 
{
    return Excel::download(new InvoiceExport, 'قائمة الفواتير.xlsx');
}


}