<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Invoice_Attachment;
use Illuminate\Http\Request;
use App\Models\invoice;

class InvoiceAttachmentController extends Controller
{
public function index($id){

    $invoice=invoice::where("id",$id)->first();
$invoice_attachments=Invoice_Attachment::where('invoice_id',$id)->get();
return view('invoice_attachments.attachments',compact('invoice',"invoice_attachments"));

}


public function create(Request $request){

    $validate=$request->validate([

"file"=>"required|mimes:pdf,jpg,jpeg,png"],[

    "file.mimes"=>"صيغة الملف غير مدعومة.يرجى ادخال الملف بالصيغ التالية pdf,jpeg,jpg,png",
"file.required"=>"يرجى ادخال الملف المطلوب",

    ]);

$invoice_id=$request->invoice_id;

$invoice_number=$request->invoice_number;

$invoice_status=$request->status;

$invoice_date=$request->invoice_date;

$due_date=$request->due_date;

$file_name=$request->file->getclientoriginalname();

$user=(Auth::user()->name);

invoice_attachment::create([

       "name"=>$file_name,

       "invoice_id"=>$invoice_id,

       "invoice_number"=>$invoice_number,

       "invoice_status"=>$invoice_status,

       "add_date"=>$invoice_date,

        "due_date"=>$due_date,

        "add_date"=>$invoice_date,

        "user"=>$user,

]);
//-----------------------move pic-------------------------

$image_name=$request->file->getclientoriginalname();

$move_pic= $request->file->move(public_path("Attachments/".$invoice_number),$image_name);

session()->flash('add',"تم اضافة المرفق بنجاح ");

return back();


}

//-------------------------------------عرض الملف------------------------

public function view_file($id){

    $invoice_attachment=Invoice_Attachment::where("id",$id)->first();

     $content=storage::disk('public_uploads')->exists("/".$invoice_attachment->invoice_number."/".$invoice_attachment->name);
   if($content){
    $pathToFile = public_path('Attachments/'.$invoice_attachment->invoice_number."/".$invoice_attachment->name);

    return response()->file($pathToFile);

}



}


public function download_file($id){

    $invoice_attachment=Invoice_Attachment::where("id",$id)->first();

     $content=storage::disk('public_uploads')->exists("/".$invoice_attachment->invoice_number."/".$invoice_attachment->name);

    if($content){

     $file=storage::disk('public_uploads')("/".$invoice_attachment->invoice_number."/".$invoice_attachment->name);

     return response()->download($file);

 }
}



public function delete_attachment(Request $request){

$id=$request->id;

$attachment_name=$request->name;

$invoice_number=$request->number;


 $invoice_attachment=Invoice_Attachment::where("id",$id)->where("name",$attachment_name)->where("invoice_number",$invoice_number)->first();


   $invoice_attachment->delete();

$content=storage::disk('public_uploads')->delete($invoice_number."/".$attachment_name);

session()->flash("delete","تم حذف المرفق بنجاح");
return back();

}
}





