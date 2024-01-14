@extends('layouts.app', ['activePage' => 'emailsection', 'titlePage' => __('Add Email Template'),'pageSlug' => 'add_email'])


@section('content')
<div class="row">
<div class="col-md-12">
<div class="card">
<div class="card-header">
<h5 class="title">@if(isset($template_id))Edit @else Add @endif Email template</h5>
<p>Please use given keywords in html it will replace with details while sending email :- <br>
#client_contract_link# for contract link<br>
#client_name_place# for Naam of client<br>
#client_functie_place# for Functie of client<br>
#client_location_place# for Plaats of client<br>
#client_postcode_place# for postocde of client<br>
#client_street_place# for street of client<br>
</p>
</div>
<form method="post" name="add_email_data"  action="{{ route('pages.saveemailtemplate') }}">
<div class="card-body" id="pdf_html_container"> 
@method('post')

@include('alerts.success')
@if(isset($id))
<div class="form-group">
    <label>{{ __('Template Name') }}</label>
   <input type="text" name="template_name" class="form-control{{ $errors->has('template_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Template Name') }}" value="{{$template_name}}">
   @include('alerts.feedback', ['field' => 'template_name'])
</div>
<div class="form-group">
    <label>{{ __('Email Subject') }}</label>
   <input type="text" name="subject" class="form-control{{ $errors->has('template_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Email Subject') }}" value="{{$subject}}">
   @include('alerts.feedback', ['field' => 'subject'])
</div>
<textarea id="tinymic_1" name="body_text">
    {!!$body_text!!}
</textarea>

<input type="hidden" name="edit_id" value="{{$id}}" />
@else
<div class="form-group">
    <label>{{ __('Template Name') }}</label>
   <input type="text" name="template_name" class="form-control{{ $errors->has('template_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Template Name') }}" value="">
   @include('alerts.feedback', ['field' => 'template_name'])
</div>
<div class="form-group">
    <label>{{ __('Email Subject') }}</label>
   <input type="text" name="subject" class="form-control{{ $errors->has('template_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Email Subject') }}" value="">
   @include('alerts.feedback', ['field' => 'subject'])
</div>
<textarea id="tinymic_1" name="body_text">
</textarea>     
@endif
</div>
<div class="card-footer"><button type="submit" class="btn btn-fill btn-primary" id="">Save Template</button>
{{ csrf_field() }}
</div>

</form>
</div>
</div>
</div>
@endsection

