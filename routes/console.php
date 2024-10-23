<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\PdfTask;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('resent_email_contract', function () {
    $one_month_later=Carbon::now()->subDays(30);
    $get_invoice_data=DB::table("invoice_table")->select("*")->where(array('order_status'=>1,"automatic_resend"=>1))->where( 'created_at', '>', $one_month_later)->get();
    $pdf_task=new PdfTask();
    
    foreach($get_invoice_data as $current_invoice_data)
    { 
        $send_to_client=$current_invoice_data->send_to_client;
        //--------get weekday-----------
       $current_day= Carbon::now()->dayOfWeek;
       if(in_array($current_day,array(0,6)))
       {
        return "weekday";
       }
       //-----------end weekdays condition----------------
       $create_time= Carbon::createFromTimestamp($send_to_client);
       $current_date=Carbon::now();
      $diffrance_days= $current_date->diffInDays($create_time);
      if($diffrance_days>5&&$current_invoice_data->resend_status_count=0)
      {
         //-------------date 5 diffrance------------
        DB::table("invoice_table")->where("id",$current_invoice_data->id)->update(array("resend_status_count"=>1));
        $pdf_task->send_contract_client_command($current_invoice_data->id);
       
      }
      else if($diffrance_days>10&&$current_invoice_data->resend_status_count=1)
      {
        //-------------------days 10 diffrance-------------
        DB::table("invoice_table")->where("id",$current_invoice_data->id)->update(array("resend_status_count"=>2));
        $pdf_task->send_contract_client_command($current_invoice_data->id);

      }
      else if($diffrance_days>28&&$current_invoice_data->resend_status_count=2)
      {
        //---------------days i 28 diffrance-------------
        DB::table("invoice_table")->where("id",$current_invoice_data->id)->update(array("resend_status_count=>3"));
        $pdf_task->send_contract_client_command($current_invoice_data->id);
       
      }
        
    }
    
})->purpose('Sending reset email based on the days');


