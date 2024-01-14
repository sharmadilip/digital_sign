@extends('layouts.app', ['activePage' => 'pdfsection', 'titlePage' => __('PDF page'),'pageSlug' => 'addpdftemplate'])


@section('content')
<div class="row">
<div class="col-md-12">
<div class="card">
<div class="card-header">
<h5 class="title">@if(isset($template_id))Edit @else Add @endif Pdf template</h5>
<p>Please use given keywords in html it will replace with details while generating pdf :- <br>
#client_signature_here# for signature<br>
#contract_numer# for contract number<br>
#client_name_place# for Naam of client<br>
#client_company_place# for company of client<br>
#client_functie_place# for Functie of client<br>
#client_location_place# for Plaats of client<br>
#client_postcode_place# for postocde of client<br>
#client_street_place# for street of client<br>
#current_date_place# for current date<br>
</p>
</div>
<form method="post" name="add_pdf_data" id="add_invoice_data" action="{{ route('pages.savepdftemplate') }}">
<div class="card-body" id="pdf_html_container"> 
@method('post')

@include('alerts.success')
@php($count=0)
@if(isset($template_id))
<div class="form-group">
    <label>{{ __('Template Name') }}</label>
   <input type="text" name="template_name" class="form-control{{ $errors->has('template_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Template Name') }}" value="{{$template_name}}">
   @include('alerts.feedback', ['field' => 'template_name'])
</div>
@foreach($pages_data as $page_row)
@php($count++)
<div style="padding-top: 10px;"><strong><h2>Page {{$count}}<h2></strong></div>
<textarea id="tinymic_{{$count}}" name="pdf_page[]">{!!$page_row!!}
</textarea>
@endforeach
<input type="hidden" name="edit_id" value="{{$template_id}}" />
@else
<div class="form-group">
    <label>{{ __('Template Name') }}</label>
   <input type="text" name="template_name" class="form-control{{ $errors->has('template_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Template Name') }}" value="">
   @include('alerts.feedback', ['field' => 'template_name'])
</div>
<div style="padding-top: 10px;"><strong><h2>Page 1<h2></strong></div>
<textarea id="tinymic_1" name="pdf_page[]">
<div style="padding-top: 200px; padding-left: 70px; font-size: 35px; font-weight: bold;">Verwerkersovereenkomst</div>
<div class="ft-16" style="padding-top: 20px; padding-left: 70px;">Dagtekening 22 oktober 2023</div>
<div style="padding-left: 110px; padding-top: 25%;"><img src="black/img/logo.jpg"></div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table class="table" style="bottom: 200px; padding-left: 30px;">
<tbody>
<tr>
<td>Money Management B.V.</td>
<td>KvK: 89847008</td>
<td>Tel: +31 (0)20-8515210</td>
</tr>
<tr>
<td>Herengracht 449a</td>
<td>BTW: NL865131648B01</td>
<td>E-mail: sales@mmincasso.nl</td>
</tr>
<tr>
<td>1017 BR Amsterdam</td>
<td>BANK: NL63INGB0006519323</td>
<td>Website: www.mmincasso.nl</td>
</tr>
</tbody>
</table>
</textarea>     
@endif
</div>
<div class="card-footer"><button type="button" class="btn btn-fill btn-primary" id="save_template_to_db">Save Template</button><button type="button" class="btn btn-fill btn-primary" id="add_new_pdf_page">Add Page</button><button type="button" id="view_data_as_pdf" class="btn btn-fill btn-primary">View as pdf</button>
{{ csrf_field() }}
</div>

</form>
</div>
</div>
</div>
@endsection

