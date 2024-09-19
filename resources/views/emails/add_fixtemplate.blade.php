@extends('layouts.app', ['activePage' => 'emailsection', 'titlePage' => __('Add Email Template'),'pageSlug' => 'add_email'])


@section('content')
<div class="row">
<div class="col-md-12">
<div class="card">
<div class="card-header">
<h5 class="title">Edit FixEmail template</h5>
<p>Please use given keywords in html it will replace with details while sending email :- <br>
#client_name_place# for Naam of client<br>
</p>
</div>
<form method="post" name="add_email_data"  action="{{ route('pages.savefixemailtemplate') }}">
<div class="card-body" id="pdf_html_container"> 
@method('post')

@include('alerts.success')
@if(isset($id))
<div class="form-group">
    <label>{{ __('Template Name') }}</label>
   <input type="text" name="template_name" readonly class="form-control{{ $errors->has('template_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Template Name') }}" value="{{$template_name}}">
   @include('alerts.feedback', ['field' => 'template_name'])
</div>
<div class="form-group{{ $errors->has('language') ? ' has-danger' : '' }}">
    <label>{{ __('Select Language') }}</label>
   <select  name="language" class="form-control{{ $errors->has('language') ? ' is-invalid' : '' }}">
      <option value="nl" @if($language=="nl") selected @endif>Dutch</option>
      <option value="en" @if($language=="en") selected @endif>English</option>
   </select>
   @include('alerts.feedback', ['field' => 'language'])
</div>
<div class="form-group">
    <label>{{ __('Email Subject') }}</label>
   <input type="text" name="subject_text" class="form-control{{ $errors->has('subject_text') ? ' is-invalid' : '' }}" placeholder="{{ __('Email Subject') }}" value="{{$subject_text}}">
   @include('alerts.feedback', ['field' => 'subject_text'])
</div>
<textarea id="tinymic_1" name="email_text">
    {!!$email_text!!}
</textarea>

<input type="hidden" name="edit_id" value="{{$id}}" />
@else    
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

