<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceSend;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;
use Mail;
use App\Mail\InvoiceSendClient;
use App\PdfTask;
use App\Models\Template;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function view_invoice(Request $request)
    {  $data=array();
        $search_text=$request->input('search_text');
        if(isset($search_text))
        {
            
        $data=array();
        $template_query=DB::table("invoice_table")->where('client_name','like','%' . $search_text . '%')->orWhere('client_company_name', 'like', '%' . $search_text . '%')->orWhere('client_email_id', 'like', '%' . $search_text . '%');
       $template_data= $template_query->orderBy('id','desc')->paginate(50);
      
       $data['search_text']=$search_text;
        }
        else{
            $template_data= DB::table("invoice_table")->orderBy('id','desc')->paginate(10);
            
        }
        $data['invoice_data']=$template_data;
       return view('invoice.invoice_list',$data);
    }
  
    public function add_invoice(Request $request)
    {    $request_data=$request->all();
        $data=array();
        $template_data= DB::table("pdf_templates")->select(array("id","template_name"))->get();
        $email_template_data= DB::table("email_template")->select(array("id","template_name"))->get();
        $data['email_template_data']=$email_template_data;
        if(isset($request_data['invoice_id']))
        {    $data['invoice_data']= DB::table("invoice_table")->select('*')->where('id',$request_data['invoice_id'])->get()->first();
            $data['template_data']=$template_data;
            return view('invoice.edit_invoice',$data);
        }
        else{
        $data['template_data']=$template_data;
        return view('invoice.add_invoice',$data);
        }
    }
    public function save_invoice(Request $request)
    {
        $request_data=$request->all();
        
        unset($request_data['_token']);
        unset($request_data['_method']);
        $get_template_id=$request_data['pdf_template_id'];
        $templade_json=DB::table("pdf_templates")->select("pdf_data_html")->where("id",$get_template_id)->get()->first();
        unset($request_data['pdf_template_id']);
        $request_data['template_id']=$get_template_id;
        $request_data['pdf_html_data']=$templade_json->pdf_data_html;
        $request_data['created_at']=Carbon::now()->toDateTimeString();
        $request_data['order_status']=0;
        if(isset( $request_data['edit_id']))
        {
            $edit_id=$request_data['edit_id'];
            unset($request_data['edit_id']);
            DB::table("invoice_table")->updateOrInsert(array("id"=>$edit_id),$request_data);
            return back()->withStatus(__('Contract Updated successfully.'));
        }
        else{
            
            DB::table("invoice_table")->insert($request_data);
            return back()->withStatus(__('Contract Added successfully.'));
        }

    }
   
    public function view_invoice_pdf(Request $request)
    {   $data=array();
        if(is_numeric($request->invoice_id))
        {
            $template_id=$request->invoice_id;
        }
        else{
         $template_id=base64_decode($request->invoice_id);
        }
        
         $pdftask=new PdfTask();
         return $pdftask->pdf_by_download($template_id);
    }
    public function send_contract_client(Request $request)
    {    $request_data=array();
         $contact_id=$request->input('contact_id');
         $data_get=DB::table("invoice_table")->select("*")->where("id",$contact_id)->get()->first();
         $data['pages_data']= json_decode($data_get->pdf_html_data);
         $email_template_replace=array();
         $email_template_replace['#contract_numer#']='MM'.(1000+$data_get->id);
         $email_template_replace['#client_name_place#']=$data_get->client_name;
         $email_template_replace['#client_functie_place#']=$data_get->client_functie;
         $email_template_replace['#client_location_place#']=$data_get->client_location;
         $email_template_replace['#client_postcode_place#']=$data_get->client_postcode;
         $email_template_replace['#client_street_place#']=$data_get->client_street;
         $contract_text="Bekijk contract";
         if($data_get->contract_type==2)
         {
            $contract_text="Bekijk offerte";
         }
         $email_template_replace['#client_contract_link#']='<a href="'.route("pages.invoiceviewcleint").'?invoice_id='.base64_encode($data_get->id).'">'.$contract_text.'</a>';
        
         $pdftask=new PdfTask();
         $pdf_url=$pdftask->pdf_by_path($contact_id);
         
         //--------------defining the email item if data is from resend-----------------
         if($data_get->order_status==1)
        { 
            $email_get_lang= DB::table("email_template")->select('language')->where('id',$data_get->email_template)->get()->first();
            $request_data['resend_status']=1;
           if($data_get->contract_type==2)
          { 
            if($email_get_lang->language=="nl")
            {$email_templ=5;}
            else{
                $email_templ=10;
            }
            
          }
          else{
            if($email_get_lang->language=="nl")
            {
                $email_templ=6;
            }
            else{
                $email_templ=11;
            }
          }
        }
        else{
            $email_templ= $data_get->email_template;
        }
        $email_template_data= DB::table("email_template")->select('*')->where('id',$email_templ)->get()->first();
         $client_email_body=$email_template_data->body_text;
         //-------------replace keywords---------------------------
          foreach($email_template_replace as $key=>$values)
          {
            $client_email_body=str_replace($key,$values,$client_email_body);
          }

         $client_subject=$email_template_data->subject;

         if(isset($email_template_data->language))
         {
            $client_language=$email_template_data->language;
         }
         else{
          $client_language="nl";
         }
        
         //---client email action------------------
         $mailData = [
            'subject' => $client_subject,
            'client_name'=>$data_get->client_name,
            'body' => $client_email_body,
            'contact_id'=>base64_encode($contact_id),
            'order_status'=>$data_get->order_status
        ];
        
       
        //-----------email section -----------------
         $client_invoice=new InvoiceSendClient($mailData);
         $client_invoice->attach($pdf_url);
         //-----------extra document attached for the client email--------------
         if($data_get->order_status!=1&&$email_template_data->extra_file!=null)
        {   $files_array=unserialize($email_template_data->extra_file);
            foreach($files_array as $pdf_attach)
            {
                $pdf_file_attached=ltrim($pdf_attach,'/');
            $client_invoice->attach($pdf_file_attached);
            }
        }
         Mail::to($data_get->client_email_id)->bcc('sales@mmincasso.nl','Sales')->send($client_invoice);

         if($data_get->order_status!=1)
        { 
            //----------------send contract detail to admin email data-----------------
          $user_email_data=  DB::table("email_text_data")->select('*')->where('template_name',"mm_invoice_send")->where("language",$client_language)->get()->first();  
          $user_template_body=$user_email_data->email_text;
          foreach($email_template_replace as $key=>$values)
          {
            $user_template_body=str_replace($key,$values,$user_template_body);
          }
          
          $user_email=['subject' => $user_email_data->subject_text,'client_name'=>$data_get->client_name,'body' => $user_template_body];
          $user_invoice=new InvoiceSend($user_email);
         $user_invoice->attach($pdf_url);
         Mail::to($data_get->user_email_id)->send($user_invoice);
        }
         //---------------end email action--------------------
          $request_data['order_status']=1;
          $request_data['send_to_client']=Carbon::now()->toDateTimeString();
          DB::table("invoice_table")->updateOrInsert(array("id"=>$contact_id),$request_data);
          return json_encode(array("success"=>"Contract Sent successfully"));
    }
public function delete_contract_data(Request $request)
{
    $contract_id=$request->input('invoice_id');
    DB::table('invoice_table')->where('id', $contract_id)->delete();
    return back()->withStatus(__('Contract Has Deleted Successfully.'));
}
    
}
