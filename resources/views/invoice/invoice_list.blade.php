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
                      <tr style="background-color: @if($my_data->order_status==1&&$my_data->client_sing==null&&$my_data->resend_status==1) #562d51; @elseif($my_data->order_status==1&&$my_data->client_sing==null) #1b2948;@elseif($my_data->order_status==2) #384227; @elseif($my_data->order_status==1&&$my_data->client_sing!=null)#97062e; @endif">
                          <td>
                            Contract {{$my_data->id}}
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
