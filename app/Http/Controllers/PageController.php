<?php

namespace App\Http\Controllers;
use PDF;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display icons page
     *
     * @return \Illuminate\View\View
     */
    
    public function icons()
    {
        return view('pages.icons');
    }

    /**
     * Display maps page
     *
     * @return \Illuminate\View\View
     */
    public function maps()
    {
        return view('pages.maps');
    }

    /**
     * Display tables page
     *
     * @return \Illuminate\View\View
     */
    public function tables()
    {
        return view('pages.tables');
    }

    /**
     * Display notifications page
     *
     * @return \Illuminate\View\View
     */
    public function notifications()
    {
        return view('pages.notifications');
    }

    /**
     * Display rtl page
     *
     * @return \Illuminate\View\View
     */
    public function pdf_generate(Request $request)
    {  
        $data_get=array();
        $input_data=$request->input('pdf_page');
        foreach($input_data as $data_row)
        {
            $data_get[]=$data_row;
        }
        $pdf = PDF::loadView('pdfs.invoice',array('pages_data'=>$data_get));
        $pdf->getDomPDF()->set_option("enable_php", true);
       // $font = $pdf->getFontMetrics()->get_font("helvetica", "bold");
       // $pdf->get_canvas()->page_text(34, 18, "{PAGE_NUM} / {PAGE_COUNT}", $font, 10, array(0, 0, 0));
       return $pdf->download('users_list.pdf');
    }

    /**
     * Display typography page
     *
     * @return \Illuminate\View\View
     */
    public function typography()
    {
        return view('pages.typography');
    }

    /**
     * Display upgrade page
     *
     * @return \Illuminate\View\View
     */
    public function upgrade()
    {
        return view('pages.upgrade');
    }
}
