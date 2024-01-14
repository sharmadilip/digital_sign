@extends('layouts.app', ['activePage' => 'emailsection', 'titlePage' => __('Template List'), 'pageSlug' => 'list_email'])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">Email Templates </h4>

          </div>
          <div class="card-body">
            @include('alerts.success')
            <div class="table-responsive">
              <table class="table">
                  <thead class=" text-primary">
                  <tr>
                      <th>
                          Template ID
                      </th>
                      <th>Template Name</th>
                      <th>Subject</th>
                      <th>
                          Added ON
                      </th>
                      <th class="text-center">
                          Action
                      </th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($table_data as $my_data)
                      <tr>
                          <td>
                            #{{$my_data->id}}
                          </td>
                          <td>
                            {{$my_data->template_name}}
                        </td>
                        <td>
                          {{$my_data->subject}}
                      </td>
                          <td>
                              {{$my_data->created_at}}
                          </td>
                          
                          <td class="text-center">
                             <a href="{{ route('pages.addemailtemplate') }}?email_template_id={{$my_data->id}}" class="text-info" >Edit</a> | <a href="{{ route('pages.deleteemailtemplate') }}?email_template_id={{$my_data->id}}"   class="text-info" >Delete</a> 
                          </td>
                      </tr>
                  @endforeach
                  </tbody>
              </table>

            </div>
              <div class="pagination pagination-sm"> {{$table_data->links()}}</div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection
