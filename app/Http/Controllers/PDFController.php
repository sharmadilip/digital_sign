<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;
use App\PdfTask;
  
class PDFController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function list_pdf_template()
    {    $table_data=DB::table("pdf_templates")->orderBy('id','desc')->paginate(20);
        $data['table_data']=$table_data;
        return view('pdfs.template_list',$data);
    }
    public function copy_pdf_template(Request $request)
    {   if(isset($request->template_id)) {
        $template_id=$request->template_id;
        $data_get=DB::table("pdf_templates")->select("*")->where("id",$template_id)->get()->first(); 
        $data['pdf_data_html']= $data_get->pdf_data_html;
        $data['template_name']=$data_get->template_name."_copy";
        $data['created_at']=Carbon::now()->toDateTimeString();
        DB::table("pdf_templates")->insert($data);
         } 
        
         return back()->withStatus(__('Pdf template successfully copied.'));
    }
    public function add_pdf_template(Request $request)
    {     $email_template_data= DB::table("email_template")->select(array("id","template_name"))->get();
        $data['email_template_data']=$email_template_data;
        if(isset($request->template_id)) {
        $template_id=$request->template_id;
        $data_get=DB::table("pdf_templates")->select("*")->where("id",$template_id)->get()->first(); 
        $data['pages_data']= json_decode($data_get->pdf_data_html);
       
        $data['template_id']=$data_get->id;
        $data['template_name']=$data_get->template_name;
        $data['email_templates_data']='';
        $data['email_templates_data_array']=array();
        if($data_get->email_templates_data!=null)
        {
        $data['email_templates_data']=$data_get->email_templates_data;
        $data['email_templates_data_array']=explode(",",$data_get->email_templates_data);
        }
        return view('pdfs.edit_template_pdf',$data);
    }
     else{
        return view('pdfs.edit_template_pdf',$data); 
      }
    }
    //----------view template on click view button by id--------------------------
    public function view_pdf_template(Request $request)
    {   if(isset($request->template_id)) {
         $template_id=$request->template_id;
        $data_get=DB::table("pdf_templates")->select("*")->where("id",$template_id)->get()->first();
       
        $data= json_decode($data_get->pdf_data_html);
        $pdftask=new PdfTask();
       return $pdftask->pdf_controler_view($data);
    }
    else{
        return back()->withStatus(__('Error in Template'));
    }
    }
    //---------------view pdf while editing the template to check view--------------------
    public function view_pdf_data(Request $request)
    {
        $data_get=array();
        $input_data=$request->input('pdf_page');
        foreach($input_data as $data_row)
        {
            $data_get[]=$data_row;
        }
        $pdftask=new PdfTask();
       return $pdftask->pdf_controler_view($data_get);
    }
//---------------------save pdf template to database or update it -------------------
    public function save_pdf_template(Request $request)
    {
        $pdf_input_data=$request->input('pdf_page');
        $edit_id=$request->input('edit_id');
        $html_data=array();
        foreach($pdf_input_data as $pdf_page)
        {   if($pdf_page!='')
            {
            $html_data[]=$pdf_page;
            }
        }
        
        $data['pdf_data_html']=json_encode( $html_data);
        $data['created_at']=Carbon::now()->toDateTimeString();
        $data['template_name']=$request->input('template_name');
        $data['email_templates_data']=$request->input('email_templates_data');
        if(isset($edit_id))
        {
           
            $request_data['pdf_data_html']=json_encode($html_data);
            $request_data['template_name']=$data['template_name'];
            $request_data['email_templates_data']=$request->input('email_templates_data');
            $request_data['updated_at']=Carbon::now()->toDateTimeString();
            DB::table("pdf_templates")->updateOrInsert(array("id"=>$edit_id),$request_data);
            return back()->withStatus(__('Pdf Template Updated successfully added.'));
        }
        else{
        DB::table("pdf_templates")->insert($data);
        return back()->withStatus(__('Pdf template successfully added.'));
        }

        
    }
    //------------delete the pdf template----------------

    public function delete_pdf_tempalte(Request $request)
    {
      $template_id=$request->input('template_id');
      DB::table('pdf_templates')->where('id', $template_id)->delete();
      $message=array("success" => "Template has been deleted");
      return json_encode($message);
    }
    
}
