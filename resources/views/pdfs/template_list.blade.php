@extends('layouts.app', ['activePage' => 'pdfsection', 'titlePage' => __('Template List'), 'pageSlug' => 'listpdf'])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">Templates </h4>

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
                              {{$my_data->created_at}}
                          </td>
                          
                          <td class="text-center">
                             <a href="{{ route('pages.addtemplate') }}?template_id={{$my_data->id}}" class="text-info" >Edit</a> | <a href="#" id="delete_pdf_template_btn" data-id="{{$my_data->id}}" class="text-info" >Delete</a> | <a href="{{ route('pages.generatepdf_template') }}?template_id={{$my_data->id}}" class="text-info" >View</a>| <a href="{{ route('pages.copypdftemplate') }}?template_id={{$my_data->id}}" class="text-info" >Copy Template</a>
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
