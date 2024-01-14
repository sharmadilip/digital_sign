<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceApproved;
use App\Mail\InvoiceApprovedClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use Mail;
use Carbon\Carbon;
use App\PdfTask;

class SignController extends Controller
{
   public function display_pdf_for(Request $request)
   {   $get_template_id=base64_decode($request->input('invoice_id')); 
    if(isset($get_template_id))
    {  $data=array();
       $templade_json=DB::table("invoice_table")->select("*")->where("id",$get_template_id)->get()->first();
       
       if(isset($templade_json->client_sing))
       {
        $signature_image='<img src="'.$templade_json->client_sing.'" width="150" />';
        $data['signature_data']=$signature_image;
       }
       
       $data['order_status']=$templade_json->order_status;
       $data['pages_data']= json_decode($templade_json->pdf_html_data);
       
       $pdftask=new PdfTask();
       $pdf_url=$pdftask->pdf_by_path($get_template_id);
       $data['pdf_url']=$pdf_url;
       $data['invoice_id']=$get_template_id;
       return view("invoice.view_invoice_client",$data);
      }
      else{
        return redirect('/');
      }
   }
  public function save_signature_to_db(Request $request)
  {
    $get_template_id=$request->input('invoice_id');
    $image_data=$request->input('signature_data');
    //Request::ip();
    $request_data['client_ip']=$request->ip();
    $request_data['client_sing']=$image_data;
    DB::table("invoice_table")->updateOrInsert(array("id"=>$get_template_id),$request_data);
    return response()->json(['success' => 'Signature added successfully.']);
  }
  public function approve_invoice_signature(Request $request)
  {
    $get_template_id=$request->input('contract_id');

    $data_get=DB::table("invoice_table")->select("*")->where("id",$get_template_id)->get()->first();
         $data['pages_data']= json_decode($data_get->pdf_html_data);
         
         $request_data['client_ip']=$request->ip();
         $request_data['order_status']=2;
         $request_data['sign_in_date']=Carbon::now()->toDateTimeString();
         DB::table("invoice_table")->updateOrInsert(array("id"=>$get_template_id),$request_data);
         $pdftask=new PdfTask();
         $pdf_url=$pdftask->pdf_by_path($get_template_id);
         //---client email action------------------
         $mailData = [
            'title' => 'Mail from Mmincasso',
            'client_name'=>$data_get->client_name,
            'body' => '',
            'contact_id'=>base64_encode($get_template_id),
        ];
        //-----------email section -----------------
         $client_invoice=new InvoiceApprovedClient($mailData);
         $client_invoice->attach($pdf_url);
         Mail::to($data_get->client_email_id)->send($client_invoice);
         $user_invoice=new InvoiceApproved($mailData);
         $user_invoice->attach($pdf_url);
         Mail::to($data_get->user_email_id)->send($user_invoice);
         //---------------end email action-------------------

   
    return response()->json(['success' => 'Contract has been approved.']);
  }
 public function download_invoice(Request $request)
 {
        $data=array();
         $template_id=base64_decode($request->invoice_id);
         $pdftask=new PdfTask();
         return $pdftask->pdf_by_download($template_id);
 }
}
