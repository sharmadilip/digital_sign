<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Illuminate\Http\Request;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {   $data=array(); 
        
        $data=array();
        $get_send_contract=DB::table("invoice_table")->select('*')->where('order_status',1)->where('send_to_client','>',Carbon::now()->subDays(60))->orderBy('id','desc')->get();
        $Approved_contract=DB::table("invoice_table")->select('*')->where('order_status',2)->where('send_to_client','>',Carbon::now()->subDays(60))->orderBy('id','desc')->get();
        $chat_data=self::get_chart_data();
        $data['chart_data_sent']=implode(',',$chat_data['send_contract']);
        $data['chart_data_approve']=implode(',',$chat_data['approve_contract']);
        $data['send_contract']=$get_send_contract;
        $data['aproved_contract']=$Approved_contract;
        return view('dashboard',$data);
    }
    function get_chart_data()
    {
        $months_data=range(1,12);

    $data=array();
    $year=date('Y');
    foreach($months_data as $month) {
        $send_contrct=DB::table("invoice_table")->select('*')->where('order_status',1)->whereYear('send_to_client',$year)->whereMonth('send_to_client', $month);
        $data['send_contract'][$month]=$send_contrct->count();
        $approve=DB::table("invoice_table")->select('*')->where('order_status',2)->whereYear('sign_in_date',$year)->whereMonth('sign_in_date', $month);
        $data['approve_contract'][$month]=$approve->count();
    }
    return $data;
    }
    
    public function view_email_tempalte()
    {
        $data=array();
        $template_data= DB::table("email_template")->orderBy('id','desc')->paginate(20);
        $data['table_data']=$template_data;
        return view('emails.template_list',$data);
    }
    public function view_fixemail_tempalte()
    {
        $data=array();
        $template_data= DB::table("email_text_data")->orderBy('id','desc')->paginate(20);
        
        $data['table_data']=$template_data;
        return view('emails.fixemail_list',$data);
    }
    public function add_email_template(Request $request)
    {   $data=array();
        $request_data=$request->all();
        $template_parent=DB::table("email_template")->select("*")->where("parent_template",0)->get();
        $data['template_parant']=$template_parent; 
        if(isset($request_data['email_template_id']))
        {
            $email_data=DB::table("email_template")->select('*')->where('id',$request_data['email_template_id'])->get()->first();
            
            $data['id']=$email_data->id;
            $data['template_name']=$email_data->template_name;
            $data['body_text']=$email_data->body_text;
            $data['parent_template']=$email_data->parent_template;
            $data['language']=$email_data->language;
            $data['subject']=$email_data->subject;
            
            if(!empty($email_data->extra_file))
            {
            $data['extra_file']=unserialize($email_data->extra_file);
            }
            else{
                $data['extra_file']=array();
            }
        }
        return view('emails.add_template',$data);
    }
    public function edit_fixemail_template(Request $request)
    {   $data=array();
        $request_data=$request->all();
        if(isset($request_data['email_template_id']))
        {
            $email_data=DB::table("email_text_data")->select('*')->where('id',$request_data['email_template_id'])->get()->first();
            $data['id']=$email_data->id;
            $data['template_name']=$email_data->template_name;
            $data['email_text']=$email_data->email_text;
            $data['language']=$email_data->language;
            $data['subject_text']=$email_data->subject_text;
        }
        return view('emails.add_fixtemplate',$data);
    }
    public function save_email_template(Request $request)
    {
        $request_data=$request->all();
         
        unset($request_data['_token']);
        unset($request_data['_method']);
        $request_data['created_at']=Carbon::now()->toDateTimeString();
        
        if($request->hasFile('extra_file'))
        {   $file_array=array();
           
            foreach($request->file('extra_file') as  $image)
            {
           // $image      = $request->file('extra_file');
             $file_name=$image->getClientOriginalName();
            $imageName  =  $file_name;
            $path       = "email_upload_pdf/".$imageName;
       
          $uploaded_file=  Storage::disk('public')->put($path, file_get_contents($image)); 
          $file_url = Storage::url('app/public/').$path;
          $file_array[]=$file_url;
         // $request_data['extra_file']=$file_url;
            }
            $request_data['extra_file']=serialize($file_array);
        }
        if(isset( $request_data['edit_id']))
        {
            $edit_id=$request_data['edit_id'];
            unset($request_data['edit_id']);
            DB::table("email_template")->updateOrInsert(array("id"=>$edit_id),$request_data);
            return back()->withStatus(__('Email Template Updated successfully.'));
        }
        else{
            
            DB::table("email_template")->insert($request_data);
            return back()->withStatus(__('Email Template Added successfully.'));
        }
    }
    public function save_fixemail_template(Request $request)
    {
        $request_data=$request->all();
         
        unset($request_data['_token']);
        unset($request_data['_method']);
        $request_data['updated_at']=Carbon::now()->toDateTimeString();
        if(isset( $request_data['edit_id']))
        {
            $edit_id=$request_data['edit_id'];
            unset($request_data['edit_id']);
            DB::table("email_text_data")->updateOrInsert(array("id"=>$edit_id),$request_data);
            return back()->withStatus(__('fixEmail Template Updated successfully.'));
        }
        else{
            
            DB::table("email_template")->insert($request_data);
            return back()->withStatus(__('Email Template Added successfully.'));
        }
    }
    public function delete_template(Request $request)
    {
        $email_temp_id=$request->input('email_template_id');
        DB::table('email_template')->where('id', $email_temp_id)->delete();
        return back()->withStatus(__('Email Template Deleted successfully.'));
    }
    //-------------public function to delete file from database--------------

    public function delete_uploaded_file(Request $request)
    {
        $file_name=$request->input('file_name');
        $email_template_id=$request->input('template_id');
       $extraFile= DB::table('email_template')->select('extra_file')->where('id', $email_template_id)->get()->first();
       $files_list=unserialize($extraFile->extra_file);
       $file_key=array_search($file_name,$files_list);
       unset($files_list[$file_key]);
       $file_data=serialize($files_list);
       DB::table("email_template")->where(array("id"=>$email_template_id))->update(["extra_file"=>$file_data]);
      echo "deleted";
    }
    
}
