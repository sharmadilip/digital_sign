@extends('layouts.app', ['activePage' => 'templatelist', 'titlePage' => __('Template List'), 'pageSlug' => 'listtemplate'])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">Contract List </h4>

          </div>
          <div class="card-body">
            <label>Color code with status</label>
            @php
                  $default_color_code=$pdf_task_model->get_setting_value('default_color_code');
                  $contract_signed_color_code=$pdf_task_model->get_setting_value('contract_signed_color');
                  $try_to_sign_in=$pdf_task_model->get_setting_value('client_try_sign_in');
                  $five_day_auto=$pdf_task_model->get_setting_value('5_days_resend_color_code');
                  $ten_day_auto=$pdf_task_model->get_setting_value('10_days_resend_color_code');
                  $twinty_day_auto=$pdf_task_model->get_setting_value('28_days_resend_color_code');
            @endphp
            <div class="row" style="padding: 5px;"><button type="button" style="background: {{$contract_signed_color_code}}" class="btn  btn-sm">Contract Signed</button>
<button type="button" style="background: {{$default_color_code}}" class="btn btn-sm ">Default</button>
<button type="button" style="background: {{$try_to_sign_in}}" class="btn btn-sm "> Client Tried For sign</button>
<button type="button" style="background: {{$five_day_auto}}" class="btn btn-sm">5 Days Autosend</button>
<button type="button" style="background: {{$ten_day_auto}}" class="btn btn-sm ">10 Days Autosend</button>
<button type="button" style="background: {{$twinty_day_auto}}" class="btn btn-sm ">28 Days Autosend</button> </div>
            <form class="form" class="" method="post" action="{{ route('pages.invoicelist') }}">
              @csrf
              <div class="row ">
                <div class="col-md-6">
                </div>
                <div class="col-md-4">
                <input type="text" name="search_text" minlength="3" class="form-control" value="@if(isset($search_text)){{$search_text}}@endif" placeholder="Search..">
                </div>
                <div class="col-md-2">
                  <button type="submit" class="btn btn-primary ">{{ __('Search') }}</button>
                </div>
              </div>
            </form>
            @include('alerts.success')
            <div class="table-responsive">
              <table class="table" style="font-size: 12px;">
                  <thead class=" text-primary">
                  <tr>
                      <th>
                        Contract ID
                      </th>
                      <th>
                        Client Company Name
                      </th>
                      <th>
                         Client Name
                      </th>
                      <th>
                         Client Email ID
                      </th>
                      <th>
                        Template
                     </th>
                      <th>
                         Status
                      </th>
                      <th>
                        Sent Date
                     </th>
                      <th class="text-center">
                          Action
                      </th>
                  </tr>
                  </thead>
                  <tbody>
                  
                  @foreach($invoice_data as $my_data)
                  @php

                  $color_code_resend=$pdf_task_model->reminder_color_scheme($my_data->id);
                  $color_code_not_auto=$pdf_task_model->get_setting_value('resend_contract_color');
                  $email_view=$pdf_task_model->email_has_been_view($my_data->id);
                 
                  @endphp
                  
                      <tr style="background-color: @if($my_data->order_status==1&&$my_data->client_sing==null&&$my_data->resend_status==1&&$my_data->automatic_resend ==0) {{$color_code_not_auto}} @elseif($my_data->order_status==1&&$my_data->client_sing==null&&$my_data->resend_status_count > 0&&$my_data->automatic_resend ==1)  {{$color_code_resend}}  @elseif($my_data->order_status==1&&$my_data->client_sing==null){{$default_color_code}}@elseif($my_data->order_status==2) {{$contract_signed_color_code}} @elseif($my_data->order_status==1&&$my_data->client_sing!=null){{ $try_to_sign_in}} @endif">
                          <td>
                             {{$my_data->id}}-{{$email_view}}
                          </td>
                          <td>
                              {{$my_data->client_company_name}}
                          </td>
                          <td>
                              {{$my_data->client_name}}
                          </td>
                          <td>
                              {{$my_data->client_email_id}}
                          </td>
                          <td>
                            {{App\Models\Template::find($my_data->template_id)->template_name}}
                            
                        </td>
                          <td>
                            @if($my_data->order_status==0)
                              In Draft
                             @elseif($my_data->order_status==1)
                              Send To Client
                              @elseif($my_data->order_status==2&&$my_data->client_sing==null)
                              Signed By Manually
                              @elseif($my_data->order_status==2)
                              Signed By client
                              @endif 
                          </td>
                          <td>{{$my_data->send_to_client}}</td>
                          <td class="text-center">
                            
                            @if($my_data->order_status==0)<a href="{{ route('pages.addinvoice') }}?invoice_id={{$my_data->id}}" class="text-info" >Edit</a>  @elseif($my_data->order_status==1)  <a href="{{ route('pages.signcontractmanully') }}?contract_id={{$my_data->id}}" class="text-info manual_sign_btn" >Manual Sign</a> | <a href="#" data-id="{{$my_data->id}}" id="send_to_client_contract" class="text-info">Re-send</a>  | @endif <a href="{{ route('pages.viewinvoice') }}?invoice_id={{$my_data->id}}" class="text-info" >View Contract</a>  @if($my_data->order_status==0)| <a href="#" data-id="{{$my_data->id}}" id="send_to_client_contract" class="text-info" >Send to client</a>@endif    | <a href="{{ route('pages.deletecontract') }}?invoice_id={{$my_data->id}}" id="delete_invoice_data" class="text-info" >Delete</a>
                          </td>
                      </tr>
                  @endforeach
                  </tbody>
              </table>

            </div>
              <div class="pagination pagination-sm"> {{$invoice_data->links()}}</div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection
