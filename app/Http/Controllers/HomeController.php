<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Illuminate\Http\Request;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
    public function add_email_template(Request $request)
    {   $data=array();
        $request_data=$request->all();
        if(isset($request_data['email_template_id']))
        {
            $email_data=DB::table("email_template")->select('*')->where('id',$request_data['email_template_id'])->get()->first();
            $data['id']=$email_data->id;
            $data['template_name']=$email_data->template_name;
            $data['body_text']=$email_data->body_text;
            $data['subject']=$email_data->subject;
        }
        return view('emails.add_template',$data);
    }
    public function save_email_template(Request $request)
    {
        $request_data=$request->all();
         
        unset($request_data['_token']);
        unset($request_data['_method']);
        $request_data['created_at']=Carbon::now()->toDateTimeString();
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
    public function delete_template(Request $request)
    {
        $email_temp_id=$request->input('email_template_id');
        DB::table('email_template')->where('id', $email_temp_id)->delete();
        return back()->withStatus(__('Email Template Deleted successfully.'));
    }
    
}
