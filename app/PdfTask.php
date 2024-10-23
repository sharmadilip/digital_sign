<?php
namespace App;
use App\Mail\InvoiceApproved;
use App\Mail\InvoiceApprovedClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mail\InvoiceSendClient;
use PDF;
use Mail;
use Carbon\Carbon;

class PdfTask
{ 
  //--------------get setting value--------------------
  public function get_setting_value($key)
  {
      $key_value=DB::table("system_settings")->select('setting_value')->where(array('setting_key'=>$key))->first();
      if(!isset($key_value->setting_value))
      {
        return "";
      }
      return $key_value->setting_value;
  }
  //---------------download pdf by contract id---------------
    public function pdf_by_download($contact_id)
    {
        $data=array();
       $templade_json=DB::table("invoice_table")->select("*")->where("id",$contact_id)->get()->first();
       $replace_keywords['#client_signature_here#']='';
       if(isset($templade_json->client_sing))
       {
        $signature_image='<img src="'.$templade_json->client_sing.'" width="150" />';
        if(isset($templade_json->sign_in_date))
        {
          $signature_image.='<br><span style="font-size:10px">Ip address:- '.$templade_json->client_ip.'</span><br>';
          $signature_image.='<span style="font-size:10px">Date:- '.$templade_json->sign_in_date.'</span>';
        }
        $replace_keywords['#client_signature_here#']=$signature_image;
       }
       $replace_keywords['#contract_numer#']='MM'.(1000+$templade_json->id);
       $replace_keywords['#client_name_place#']=$templade_json->client_name;
       $replace_keywords['#client_company_place#']=$templade_json->client_company_name;
       $replace_keywords['#client_location_place#']=$templade_json->client_location;
       $replace_keywords['#client_functie_place#']=$templade_json->client_functie;
       $replace_keywords['#client_postcode_place#']=$templade_json->client_postcode;
       $replace_keywords['#client_street_place#']=$templade_json->client_street;
       $replace_keywords['#current_date_place#']=$this->replace_date_month(Carbon::parse($templade_json->send_to_client)->format('d F Y'));
       $data['replace_keywords']=$replace_keywords;
       $data['order_status']=$templade_json->order_status;
       $data['pages_data']= json_decode($templade_json->pdf_html_data);
       $pdf = PDF::loadView('pdfs.invoice',$data);
       $pdf->getDomPDF()->set_option("enable_php", true);
        // $font = $pdf->getFontMetrics()->get_font("helvetica", "bold");
       // $pdf->get_canvas()->page_text(34, 18, "{PAGE_NUM} / {PAGE_COUNT}", $font, 10, array(0, 0, 0));
       $template_name=DB::table("pdf_templates")->select("template_name")->where("id",$templade_json->template_id)->get()->first();
       if(isset($template_name->template_name))
       {
        $my_pdf_name=$template_name->template_name;
       }
       else{
        $my_pdf_name=$templade_json->client_name;
       }
       return $pdf->download($my_pdf_name.'.pdf');

    }
    public function pdf_by_path($contact_id)
    {   
        $data=array();
       $templade_json=DB::table("invoice_table")->select("*")->where("id",$contact_id)->get()->first();
       $replace_keywords=array();
       $replace_keywords['#client_signature_here#']='';
       if(isset($templade_json->client_sing))
       {
        $signature_image='<img src="'.$templade_json->client_sing.'" width="150" />';
        if(isset($templade_json->sign_in_date))
        {
          $signature_image.='<br><span style="font-size:10px">Ip address:- '.$templade_json->client_ip.'</span><br>';
          $signature_image.='<span style="font-size:10px">Date:- '.$templade_json->sign_in_date.'</span>';
        }
        $replace_keywords['#client_signature_here#']=$signature_image;
       }
       $replace_keywords['#contract_numer#']='MM'.(1000+$templade_json->id);
       $replace_keywords['#client_name_place#']=$templade_json->client_name;
       $replace_keywords['#client_company_place#']=$templade_json->client_company_name;
       $replace_keywords['#client_location_place#']=$templade_json->client_location;
       $replace_keywords['#client_functie_place#']=$templade_json->client_functie;
       $replace_keywords['#client_postcode_place#']=$templade_json->client_postcode;
       $replace_keywords['#client_street_place#']=$templade_json->client_street;
       $replace_keywords['#current_date_place#']=$this->replace_date_month(Carbon::parse($templade_json->send_to_client)->format('d F Y'));
       $template_name=DB::table("pdf_templates")->select("template_name")->where("id",$templade_json->template_id)->get()->first();
       //---------------pdf url----------
       if(isset($template_name->template_name))
       {
        $my_pdf_name=$template_name->template_name;
       }
       else{
        $my_pdf_name=$templade_json->client_name;
       }
      
       $url= 'pdfs/'.preg_replace('/[^A-Za-z0-9\-]/', '',str_replace(' ','_',$my_pdf_name)).'.pdf';
       $data['replace_keywords']=$replace_keywords;
       $data['order_status']=$templade_json->order_status;
       $data['pages_data']= json_decode($templade_json->pdf_html_data);
       $pdf = PDF::loadView('pdfs.invoice',$data);
       $pdf->getDomPDF()->set_option("enable_php", true);
       $pdf->save(storage_path($url));
       return 'storage/'.$url;
    }
    public function pdf_controler_view($data_get)
    {       
        $today_date=$this->replace_date_month(Carbon::today()->format('d F Y'));
        $data_get=str_replace('#current_date_place#',$today_date,$data_get);
        $pdf = PDF::loadView('pdfs.invoice',array('pages_data'=>$data_get));
        $pdf->getDomPDF()->set_option("enable_php", true);
        return $pdf->download('pdf_view.pdf');
    }
    public function replace_date_month($date)
    { $months_value=array('January'=>'Januari','February'=>'Februari','March'=>'Maart','May'=>'Mei','June'=>'Juni','July'=>'juli','August'=>'Augustus'
      ,'October'=>'oktober');
      foreach($months_value as $key=>$value)
      {
        $date=str_replace($key,$value,$date);
      }
       return strtolower($date);    
    }
    //-----------------------sendcontract _client command use here --------------
    public function send_contract_client_command($contact_id,$resend_status="")
    {    $request_data=array();
        
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
        
         //$pdftask=new PdfTask();
         $pdf_url=$this->pdf_by_path($contact_id);
         
         //--------------defining the email item if data is from resend-----------------
         if($data_get->order_status==1)
        {   
         
          $email_templ=self::get_email_template_reminder($data_get->template_id,$resend_status);
          
          //----------old code for get resend data values--------------
            if($email_templ=="")
            {
            $email_get_lang= DB::table("email_template")->select('language')->where('id',$data_get->email_template)->get()->first();
            $request_data['resend_status']=1;
            //-----------older section start-----------------
           
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
           //------------------end of the old code--------------------
         
        }
        else{
            $email_templ= $data_get->email_template;
            //-----------------first time send to client status set------------
            $request_data['send_to_client']=Carbon::now()->toDateTimeString();
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
         $client_email_body.='<p style="display:none"><img src="'.url('validate_email_view').'?invoice_id='.base64_encode($contact_id).'"></p>';
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

         
         //---------------end email action--------------------
          $request_data['order_status']=1;
         
          DB::table("invoice_table")->updateOrInsert(array("id"=>$contact_id),$request_data);
         
    }
//----------------This function bill return color coding scheme for code base on reminder days----------------
    public function reminder_color_scheme($contract_id)
    {
      $contract_data=DB::table("invoice_table")->select("*")->where(array("id"=>$contract_id,'automatic_resend'=>1))->get()->first();
       if(empty($contract_data))
       {
        return self::get_setting_value('default_color_code');
       }
      $send_to_client=$contract_data->send_to_client;
      $create_time= Carbon::createFromTimestamp($send_to_client);
      $current_date=Carbon::now();
      $diffrance_days= $current_date->diffInDays($create_time);
      
     if($diffrance_days>5&&$contract_data->resend_status_count=0)
     {
       //-------------date 5 diffrance------------
       $color_code=self::get_setting_value('5_days_resend_color_code');
  
      
     }
     else if($diffrance_days>10&&$contract_data->resend_status_count=1)
     {
    //-------------------days 10 diffrance-------------
    $color_code=self::get_setting_value('10_days_resend_color_code');

     }
     else if($diffrance_days > 28&&$contract_data->resend_status_count=2)
     {
       //---------------days i 28 diffrance-------------
       $color_code=self::get_setting_value('28_days_resend_color_code');
       
     }
     return $color_code;
    }
    //-----------------function for allow email is viewed----------------
    public function email_has_been_view($contract_id)
    {
      $email_count=DB::table("email_open_verfication")->where("contract_id",$contract_id)->count();
      $email_view_cout="No";
      if($email_count > 0)
      {$email_view_cout="Yes";}
      return $email_view_cout;
    }
   //-------------------return email template id for reminder-------------------

   public function get_email_template_reminder($template_id,$resend_button='')
   {
    $contract_data=DB::table("pdf_templates")->select("*")->where(array("id"=>$template_id))->get()->first();
    $email_templates_string=$contract_data->email_templates_data;
    $email_template_array=array();
    if($email_templates_string!='')
    {
      $email_template_array=explode(",",$email_templates_string);
    }
    else{
      return "";
    }
    if($resend_button!='')
    {
      return $email_template_array[0];
    }
    elseif($contract_data->automatic_resend==0)
    {
      return $email_template_array[0];
    }
    elseif($contract_data->automatic_resend==1)
    {
      return $email_template_array[1];
    }
    elseif($contract_data->automatic_resend==2)
    {
      return $email_template_array[3];
    }

   }

}