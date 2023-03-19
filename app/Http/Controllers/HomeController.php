<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\invoice;
class HomeController extends Controller
{






    public function count_invoices(){

        $data['all_invoices']=invoice::all()->count();
        $data['sum_all_invoices']=invoice::all()->sum('total');


      $data['count_unpaid_invoices']=invoice::where('status_value','2')->count();
       $data['sum_unpaid_invoices']=invoice::where('status_value','2')->sum('total');
       if( $data['sum_all_invoices']){

      $data['percent_unpaid_invoice']=( $data['sum_unpaid_invoices']/$data['sum_all_invoices']*100);


       }


   $data['count_paid_invoices']=invoice::where('status_value','1')->count();
   $data['sum_paid_invoices']=invoice::where('status_value','1')->sum('total');
   if( $data['sum_all_invoices']){
    $data['percent_paid_invoice']=($data['sum_paid_invoices']/$data['sum_all_invoices']*100);
     }



        $data['count_partial_invoices']=invoice::where('status_value','3')->count();
         $data['sum_partial_invoices']=invoice::where('status_value','3')->sum('total');

         if( $data['sum_all_invoices']){
            $data['percent_partial_invoice']=($data['sum_partial_invoices']/$data['sum_all_invoices']*100);
        }









     //-----------------------------الاول

     if($data['sum_all_invoices']){

             $data['chartjs1'] = app()->chartjs
             ->name('barChartTest')
             ->type('bar')
             ->size(['width' => 400, 'height' => 180])
             ->labels([' الفواتير المدفوعة', 'الفواتير الغير مدفوعة',"الفواتير المدفوعة جزئيا"])
             ->datasets([
                 [
                     "label" => " نسبة الفواتير   ",
                     'backgroundColor' => ['#2ECC71', '#B71C0C','#39D5FF'],

                        'data' => [round($data['percent_paid_invoice']), round($data['percent_unpaid_invoice']),round($data['percent_partial_invoice'])]

                 ]




             ])
             ->options([]);



     //-----------------------------------------الثانى-----------------------------

     $data['chartjs2'] = app()->chartjs
             ->name('pieChartTest')
             ->type('pie')
             ->size(['width' => 400, 'height' => 290])
             ->labels([' الفواتير المدفوعة', 'الفواتير الغير مدفوعة',"الفواتير المدفوعة جزئيا"])
             ->datasets([
                 [
                     'backgroundColor' => ['#2ECC71', '#B71C0C','#39D5FF'],
                      'data' => [round($data['percent_paid_invoice']), round($data['percent_unpaid_invoice']),round($data['percent_partial_invoice'])]
                 ]
             ])
             ->options([]);
            }

             return view('index',$data);
         }




}

