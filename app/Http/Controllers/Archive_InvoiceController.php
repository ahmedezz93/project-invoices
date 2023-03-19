<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\invoice;
class Archive_InvoiceController extends Controller
{
        
    public function index(){
        
        $invoices=invoice::onlyTrashed()->get();
        return view('invoices.archive_invoice',compact('invoices'));
        }


    //------------------------نقل الفاتورة للارشيف
public function archive_invoice($id){

    $invoices=invoice::where("id",$id)->delete();

    session()->flash("archive","تم نقل الفاتورة للأرشيف بنجاح");
    
    return back();
}


    public function archived_invoice(Request $request){

        invoice::where("id",$request->id)->delete();
        session()->flash("archive","تم أرشفة الفاتورة بنجاح");
        return back();
        }
        //--------------------------------------------------------------------



        public function transfer_invoice(Request $request){
         invoice::withTrashed()->where("id",$request->id)->restore();
         session()->flash("transfer_invoice","تم الغاء أرشفة الفاتورة");
         return back();
            
        }

        

public function delete_archived_invoice(Request $request){

    invoice::withTrashed()->where("id",$request->id)->forcedelete();
    session()->flash("delete","تم حذف الفاتورة بنجاح");
    return back();
    
    }
    

        }
