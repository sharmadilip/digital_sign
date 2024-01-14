@extends('layouts.app', ['activePage' => 'templatelist', 'titlePage' => __('Template List'), 'pageSlug' => 'pages.viewinvoice'])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary text-center">
            

          </div>
          <form method="post" id="signature_area_form" action="{{ route('pages.saveinvoice') }}" autocomplete="off">
          @csrf
          @method('post')
          @include('alerts.success')
          <input type="hidden" name="invoice_id" id="invoice_id" value="{{$invoice_id}}" />
          <input type="hidden" name="signature_data" id="signature_data_value" />
          <style>
  #pdf_viewer_canvas {
    width: 100%;
    overflow-y:scroll;
    height: 700px;
  }
  
  
  #pdf_viewer_canvas canvas {
    margin: 20px auto;
    display: block;
  }
  .kbw-signature {
	display: inline-block;
	border: 1px solid #a0a0a0;
	-ms-touch-action: none;
}
.kbw-signature-disabled {
	opacity: 0.35;
}
</style>
       
          <div class="card-body">
           <div style="width: 100%;text-align:center;"> <a  href="{{ route('pages.viewcontract') }}?invoice_id={{base64_encode($invoice_id)}}"  class="btn btn-info btn-sm  btn-round"> <i class="tim-icons icon-cloud-download-93"></i> Download Contract </a></div>
           @include('alerts.success')
          <div id="pdf_viewer_canvas" ></div>
  </div>
  
            
             <div class="card-footer text-center">
               @if($order_status!=2)<button type="button" data-toggle="modal" data-target="#paint_signature" class="btn btn-fill btn-info btn-sm">{{ __('Voeg handtekening toe') }}</button> <button type="button" data-toggle="modal" data-target="#upload_signature" class="btn btn-fill btn-info btn-sm">{{ __('Upload handtekening') }}</button> @endif @if(isset($signature_data)&&$order_status!=2)<button type="button" id="approve_signature_digital" class="btn btn-fill btn-info btn-sm">{{ __('Contract goedkeuren') }}</button> @endif
             
             @if($order_status==2)<button type="button" class="btn btn-fill btn-info btn-sm">Ondertekend</button>@endif </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>

<div class="modal modal-search fade show" id="paint_signature" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
  <p class="text-danger">Draw your signature in the box</p>
</div>
<div class="modal-body">
<div class="row">
      <div class="col-md-4">

      <div class="form-group"><button  id="clear_signature_pad"  class="btn  btn-sm ">{{ __('Verwijderen') }}</button></div>
     <div><button  id="save_signature"  class="btn btn-sm">{{ __('Opslaan') }}</button></div>
      </div>
      <div class="col-md-6 " >
      <canvas id="signature" class="pull-left" width="450" height="150" style="border: 1px solid black;"></canvas>
      </div>
</div>

</div>
</div>
</div>
</div>

<div class="modal  fade show" id="upload_signature" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
  <div class="modal-content">
  <div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
          </button>
    <p class="text-danger">Upload your signature </p>
    <hr>
  </div>
  <div class="modal-body">
  <div class="row">
        <div class="col-md-12">
  
          <input id="signature_input"  accept="image/*" type="file">
          <img src="" id="display_signature" width="150" />
       <div><button  id="upload_your_signature"   class="btn btn-sm">{{ __('Voeg handtekening toe') }}</button></div>
       
          
        </div>
  </div>
  
  </div>
  </div>
  </div>
  </div>
@endsection

