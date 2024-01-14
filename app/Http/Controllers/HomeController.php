<?php

namespace App\Http\Controllers;
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
        $get_send_contract=DB::table("invoice_table")->select('*')->where('order_status',1)->where('send_to_client','>',Carbon::now()->subDays(30))->get();
        $Approved_contract=DB::table("invoice_table")->select('*')->where('order_status',2)->where('send_to_client','>',Carbon::now()->subDays(30))->get();
        $data['send_contract']=$get_send_contract;
        $data['aproved_contract']=$Approved_contract;
        return view('dashboard',$data);
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
