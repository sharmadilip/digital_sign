<?php
namespace App;
use App\Mail\InvoiceApproved;
use App\Mail\InvoiceApprovedClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use Mail;
use Carbon\Carbon;

class PdfTask
{ 
    
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
    


}