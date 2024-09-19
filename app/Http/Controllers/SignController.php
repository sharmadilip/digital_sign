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
         $email_template_replace=array();
         $email_template_replace['#contract_numer#']='MM'.(1000+$data_get->id);
         $email_template_replace['#client_name_place#']=$data_get->client_name;
         $email_template_replace['#client_functie_place#']=$data_get->client_functie;
         $email_template_replace['#client_location_place#']=$data_get->client_location;
         $email_template_replace['#client_postcode_place#']=$data_get->client_postcode;
         $email_template_replace['#client_street_place#']=$data_get->client_street;
         $email_template_data= DB::table("email_template")->select('*')->where('id',$data_get->email_template)->get()->first();
         $request_data['client_ip']=$request->ip();
         $request_data['order_status']=2;
         $request_data['sign_in_date']=Carbon::now()->toDateTimeString();
         DB::table("invoice_table")->updateOrInsert(array("id"=>$get_template_id),$request_data);
         $pdftask=new PdfTask();
         $pdf_url=$pdftask->pdf_by_path($get_template_id);
         //---client email action------------------
         $email_template_language="nl";
         if(isset($email_template_data->language))
         {
         $email_template_language=$email_template_data->language;
         }
         
        //-----------email section -----------------
         $client_invoice_email= DB::table("email_text_data")->select('*')->where('template_name',"client_contract")->where("language",$email_template_language)->get()->first(); 
         $client_email_body=$client_invoice_email->email_text;
         foreach($email_template_replace as $key=>$values)
          {
            $client_email_body=str_replace($key,$values,$client_email_body);
          }
         $mailData = [
          'subject' => $client_invoice_email->subject_text,
          'client_name'=>$data_get->client_name,
          'body' => $client_email_body,
          'contact_id'=>base64_encode($get_template_id),
      ];
         $client_invoice=new InvoiceApprovedClient($mailData);
         $client_invoice->attach($pdf_url);
         Mail::to($data_get->client_email_id)->bcc('sales@mmincasso.nl','Sales')->send($client_invoice);
         $user_invoice_email= DB::table("email_text_data")->select('*')->where('template_name',"mm_contract")->where("language",$email_template_language)->get()->first(); 
         $useremail_body=$user_invoice_email->email_text;
         foreach($email_template_replace as $key=>$values)
          {
            $useremail_body=str_replace($key,$values,$useremail_body);
          }
         $mailData = [
          'subject' => $user_invoice_email->subject_text,
          'client_name'=>$data_get->client_name,
          'body' => $useremail_body,
          'contact_id'=>base64_encode($get_template_id),
            ];
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
//-------------------sign the contract manully------------------------------
 public function sign_contract_manully(Request $request)
{
    
    $get_template_id=$request->input('contract_id');

    $data_get=DB::table("invoice_table")->select("*")->where("id",$get_template_id)->get()->first();
         $data['pages_data']= json_decode($data_get->pdf_html_data);
         $request_data['client_ip']=$request->ip();
         $request_data['order_status']=2;
         $request_data['sign_in_date']=Carbon::now()->toDateTimeString();
         $request_data['pdf_html_data']=str_replace('#client_signature_here#','Buiten portaal om geaccordeerd',$data['pages_data']);
         DB::table("invoice_table")->updateOrInsert(array("id"=>$get_template_id),$request_data);
         return back()->withStatus(__('Contract has been approved Manully.'));
}
}
