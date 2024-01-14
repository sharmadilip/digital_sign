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
            @include('alerts.success')
            <div class="table-responsive">
              <table class="table">
                  <thead class=" text-primary">
                  <tr>
                      <th>
                        Contract ID
                      </th>
                      <th>
                         User Name
                      </th>
                      <th>
                         Client Name
                      </th>
                      <th>
                         Client Email ID
                      </th>
                      <th>
                         Status
                      </th>
                      <th class="text-center">
                          Action
                      </th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($invoice_data as $my_data)
                      <tr>
                          <td>
                            Contract {{$my_data->id}}
                          </td>
                          <td>
                              {{$my_data->user_name}}
                          </td>
                          <td>
                              {{$my_data->client_name}}
                          </td>
                          <td>
                              {{$my_data->client_email_id}}
                          </td>
                          <td>
                            @if($my_data->order_status==0)
                              In Draft
                             @elseif($my_data->order_status==1)
                              Send To Client
                              @elseif($my_data->order_status==2)
                              Signed By client
                              @endif 
                          </td>
                          <td class="text-center">
                            
                            @if($my_data->order_status==0)<a href="{{ route('pages.addinvoice') }}?invoice_id={{$my_data->id}}" class="text-info" >Edit</a> | @endif <a href="{{ route('pages.viewinvoice') }}?invoice_id={{$my_data->id}}" class="text-info" >View Contract</a>  @if($my_data->order_status==0)| <a href="#" data-id="{{$my_data->id}}" id="send_to_client_contract" class="text-info" >Send to client</a>@endif  | <a href="{{ route('pages.deletecontract') }}?invoice_id={{$my_data->id}}" id="delete_invoice_data" class="text-info" >Delete</a>
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
