@extends('layouts.app', ['activePage' => 'templatelist', 'titlePage' => __('Template List'), 'pageSlug' => 'addinvoicePages'])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">Edit Contract  </h4>
             
          </div>
          <form method="post" action="{{ route('pages.saveinvoice') }}" autocomplete="off">
          <div class="card-body">
          @csrf
          @method('post')
          @include('alerts.success')
              <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                              <label>{{ __('User Name') }}</label>
                             <input type="text" name="user_name" class="form-control{{ $errors->has('user_name') ? ' is-invalid' : '' }}" placeholder="{{ __('User Name') }}" value="{{$invoice_data->user_name}}">
                             @include('alerts.feedback', ['field' => 'user_name'])
                        </div>
                        <div class="form-group{{ $errors->has('user_email_id') ? ' has-danger' : '' }}">
                              <label>{{ __('User Email ID') }}</label>
                             <input type="email" readonly name="user_email_id" class="form-control{{ $errors->has('user_email_id') ? ' is-invalid' : '' }}" placeholder="{{ __('User Email ID') }}" value="{{$invoice_data->user_email_id}}">
                             @include('alerts.feedback', ['field' => 'user_email_id'])
                        </div>
                        <div class="form-group{{ $errors->has('client_name') ? ' has-danger' : '' }}">
                              <label>{{ __('Cleint Name') }}</label>
                             <input type="text" name="client_name" class="form-control{{ $errors->has('client_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Client Name') }}" value="{{$invoice_data->client_name}}">
                             @include('alerts.feedback', ['field' => 'client_name'])
                        </div>
                        <div class="form-group{{ $errors->has('client_company_name') ? ' has-danger' : '' }}">
                          <label>{{ __('Cleint Company Name') }}</label>
                         <input type="text" name="client_company_name" class="form-control{{ $errors->has('client_company_name') ? ' is-invalid' : '' }}" placeholder="{{ __('Client Company Name') }}" value="{{$invoice_data->client_company_name}}">
                         @include('alerts.feedback', ['field' => 'client_company_name'])
                    </div>
                        <div class="form-group{{ $errors->has('client_email_id') ? ' has-danger' : '' }}">
                              <label>{{ __('Cleint Email ID') }}</label>
                             <input type="email" name="client_email_id" class="form-control{{ $errors->has('client_email_id') ? ' is-invalid' : '' }}" placeholder="{{ __('Client Email ID') }}" value="{{$invoice_data->client_email_id}}">
                             @include('alerts.feedback', ['field' => 'client_email_id'])
                        </div>
                        <div class="form-group{{ $errors->has('client_location') ? ' has-danger' : '' }}">
                          <label>{{ __('Client Location') }}</label>
                         <input type="text" name="client_location" class="form-control{{ $errors->has('client_location') ? ' is-invalid' : '' }}" placeholder="{{ __('Client Location') }}" value="{{$invoice_data->client_location}}">
                         @include('alerts.feedback', ['field' => 'client_location'])
                        </div>
                        <div class="form-group{{ $errors->has('client_street') ? ' has-danger' : '' }}">
                          <label>{{ __('Client Street') }}</label>
                         <input type="text" name="client_street" class="form-control{{ $errors->has('client_street') ? ' is-invalid' : '' }}" placeholder="{{ __('Client Street') }}" value="{{$invoice_data->client_street}}">
                         @include('alerts.feedback', ['field' => 'client_street'])
                         </div>
                         <div class="form-group{{ $errors->has('client_postcode') ? ' has-danger' : '' }}">
                          <label>{{ __('Client Postcode') }}</label>
                         <input type="text" name="client_postcode" class="form-control{{ $errors->has('client_postcode') ? ' is-invalid' : '' }}" placeholder="{{ __('Client Postcode') }}" value="{{$invoice_data->client_postcode}}">
                         @include('alerts.feedback', ['field' => 'client_postcode'])
                         </div>
      
                        <div class="form-group{{ $errors->has('client_functie') ? ' has-danger' : '' }}">
                          <label>{{ __('Client Functie') }}</label>
                         <input type="text" name="client_functie" class="form-control{{ $errors->has('client_functie') ? ' is-invalid' : '' }}" placeholder="{{ __('Client Functie') }}" value="{{$invoice_data->client_functie}}">
                         @include('alerts.feedback', ['field' => 'client_functie'])
                         </div>
                        <div class="form-group{{ $errors->has('pdf_template_id') ? ' has-danger' : '' }}">
                              <label>{{ __('Select PDF Design') }}</label>
                             <select  name="pdf_template_id" class="form-control{{ $errors->has('pdf_template_id') ? ' is-invalid' : '' }}">
                                @foreach($template_data as $template)
                                <option value="{{$template->id}}" @if($template->id==$invoice_data->template_id) selected @endif >{{$template->template_name}}</option>
                                @endforeach
                             </select>
                             @include('alerts.feedback', ['field' => 'pdf_template_id'])
                        </div>
                        <div class="form-group{{ $errors->has('	email_template') ? ' has-danger' : '' }}">
                          <label>{{ __('Select Email Template') }}</label>
                         <select  name="email_template" class="form-control{{ $errors->has('email_template') ? ' is-invalid' : '' }}">
                            @foreach($email_template_data as $email_template)
                            <option value="{{$email_template->id}}" @if($email_template->id==$invoice_data->email_template) selected @endif>{{$email_template->template_name}}</option>
                            @endforeach
                         </select>
                         @include('alerts.feedback', ['field' => 'email_template'])
                    </div>
                    <div class="form-group{{ $errors->has('	contract_type') ? ' has-danger' : '' }}">
                          <label>{{ __('Contract Type') }}</label>
                         <select  name="contract_type" class="form-control{{ $errors->has('contract_type') ? ' is-invalid' : '' }}">
                            
                            <option value="1" @if(1==$invoice_data->contract_type) selected @endif>Contract</option>
                            <option value="2" @if(2==$invoice_data->contract_type) selected @endif>Quotation</option>
                         </select>
                         @include('alerts.feedback', ['field' => 'contract_type'])
                    </div>
                     </div>
             <div class="card-footer">
               <button type="submit" class="btn btn-fill btn-primary">{{ __('Save') }}</button>
               <input type="hidden" name="edit_id" value="{{$invoice_data->id}}" />
              </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection