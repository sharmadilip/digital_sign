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
        $pdf_task_model=new PdfTask;
        $data['pdf_task_model']=$pdf_task_model;
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
    {    
          $contact_id=$request->input('contact_id');
          //-----------function moved to pdf task ----------------
          $pdf_task=new PdfTask();
          $pdf_task->send_contract_client_command($contact_id,"yes");
          return json_encode(array("success"=>"Contract Sent successfully"));
    }
public function delete_contract_data(Request $request)
{
    $contract_id=$request->input('invoice_id');
    DB::table('invoice_table')->where('id', $contract_id)->delete();
    return back()->withStatus(__('Contract Has Deleted Successfully.'));
}


}
