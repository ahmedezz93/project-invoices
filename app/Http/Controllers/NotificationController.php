<?php

namespace App\Http\Controllers;

use App\Models\invoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class NotificationController extends Controller
{


public function read_notification($id){

$notification_id=DB::table('notifications')->where('data->invoice_id',$id)->pluck('id');
$read_notification=DB::table('notifications')->where('id',$notification_id)->update(["read_at"=>now()]);
$invoices=invoice::all();
return view ('invoices.invoices',compact('invoices'));

} 


}
