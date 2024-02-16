@extends('layouts.app', ['activePage' => 'templatelist', 'titlePage' => __('Template List'), 'pageSlug' => 'addinvoicePages'])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">Add Contract  </h4>
             
          </div>
          <form method="post" action="{{ route('pages.saveinvoice') }}" autocomplete="off">
          <div class="card-body">
          @csrf
          @method('post')
          @include('alerts.success')
              <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                              <label>{{ __('User Name') }}</label>
                             <input type="text" name="user_name" class="form-control{{ $errors->has('user_name') ? ' is-invalid' : '' }}" placeholder="{{ __('User Name') }}" value="Igor van der Werf">
                             @include('alerts.feedback', ['field' => 'user_name'])
                        </div>
                        <div class="form-group{{ $errors->has('user_email_id') ? ' has-danger' : '' }}">
                              <label>{{ __('User Email ID') }}</label>
                             <input type="email" readonly name="user_email_id" class="form-control{{ $errors->has('user_email_id') ? ' is-invalid' : '' }}" placeholder="{{ __('User Email ID') }}" value="sales@mmincasso.nl">
                             @include('alerts.feedback', ['field' => 'user_email_id'])
                        </div>
                        <div class="form-group{{ $errors->has('client_name') ? ' has-danger' : '' }}">
                              <label>{{ __('Client Name') }}</label>
                             <input type="text" name="client_name" class="form-control{{ $errors->has('client_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Client Name') }}" value="">
                             @include('alerts.feedback', ['field' => 'client_name'])
                        </div>
                        <div class="form-group{{ $errors->has('client_company_name') ? ' has-danger' : '' }}">
                          <label>{{ __('Client Company Name') }}</label>
                         <input type="text" name="client_company_name" class="form-control{{ $errors->has('client_company_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Client Company Name') }}" value="">
                         @include('alerts.feedback', ['field' => 'client_company_name'])
                    </div>
                        <div class="form-group{{ $errors->has('client_email_id') ? ' has-danger' : '' }}">
                              <label>{{ __('Client Email ID') }}</label>
                             <input type="email" name="client_email_id" class="form-control{{ $errors->has('client_email_id') ? ' is-invalid' : '' }}" placeholder="{{ __('Client Email ID') }}" value="">
                             @include('alerts.feedback', ['field' => 'client_email_id'])
                        </div>
                        <div class="form-group{{ $errors->has('client_location') ? ' has-danger' : '' }}">
                          <label>{{ __('Client Location') }}</label>
                         <input type="text" name="client_location" class="form-control{{ $errors->has('client_location') ? ' is-invalid' : '' }}" placeholder="{{ __('Client Location') }}" value="">
                         @include('alerts.feedback', ['field' => 'client_location'])
                         </div>
                         <div class="form-group{{ $errors->has('client_street') ? ' has-danger' : '' }}">
                          <label>{{ __('Client Street') }}</label>
                         <input type="text" name="client_street" class="form-control{{ $errors->has('client_street') ? ' is-invalid' : '' }}" placeholder="{{ __('Client Street') }}" value="">
                         @include('alerts.feedback', ['field' => 'client_street'])
                         </div>
                         <div class="form-group{{ $errors->has('client_postcode') ? ' has-danger' : '' }}">
                          <label>{{ __('Client Postcode') }}</label>
                         <input type="text" name="client_postcode" class="form-control{{ $errors->has('client_postcode') ? ' is-invalid' : '' }}" placeholder="{{ __('Client Postcode') }}" value="">
                         @include('alerts.feedback', ['field' => 'client_postcode'])
                         </div>
                         <div class="form-group{{ $errors->has('client_functie') ? ' has-danger' : '' }}">
                          <label>{{ __('Client Functie') }}</label>
                         <input type="text" name="client_functie" class="form-control{{ $errors->has('client_functie') ? ' is-invalid' : '' }}" placeholder="{{ __('Client Functie') }}" value="">
                         @include('alerts.feedback', ['field' => 'client_functie'])
                         </div>
                        <div class="form-group{{ $errors->has('pdf_template_id') ? ' has-danger' : '' }}">
                              <label>{{ __('Select PDF Design') }}</label>
                             <select  name="pdf_template_id" class="form-control{{ $errors->has('pdf_template_id') ? ' is-invalid' : '' }}">
                                @foreach($template_data as $template)
                                <option value="{{$template->id}}" >{{$template->template_name}}</option>
                                @endforeach
                             </select>
                             @include('alerts.feedback', ['field' => 'pdf_template_id'])
                        </div>
                        <div class="form-group{{ $errors->has('	email_template') ? ' has-danger' : '' }}">
                          <label>{{ __('Select Email Template') }}</label>
                         <select  name="email_template" class="form-control{{ $errors->has('email_template') ? ' is-invalid' : '' }}">
                            @foreach($email_template_data as $email_template)
                            <option value="{{$email_template->id}}">{{$email_template->template_name}}</option>
                            @endforeach
                         </select>
                         @include('alerts.feedback', ['field' => 'email_template'])
                    </div>
                    <div class="form-group{{ $errors->has('	contract_type') ? ' has-danger' : '' }}">
                          <label>{{ __('Contract Type') }}</label>
                         <select  name="contract_type" class="form-control{{ $errors->has('contract_type') ? ' is-invalid' : '' }}">
                            
                            <option value="1">Contract</option>
                            <option value="2">Quotation</option>
                         </select>
                         @include('alerts.feedback', ['field' => 'contract_type'])
                    </div>
                     </div>
             <div class="card-footer">
               <button type="submit" class="btn btn-fill btn-primary">{{ __('Save') }}</button>
              </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection
