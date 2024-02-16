@extends('layouts.app', ['activePage' => 'userprofile', 'titlePage' => __('User Managment'), 'pageSlug' => 'userlist'])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">User List </h4>

          </div>
          <div class="card-body">
            @include('alerts.success')
            <button type="button" data-toggle="modal" data-target="#register_model" class="btn btn-primary btn-sm pull-right">Add New</button>
            <div class="table-responsive">
              <table class="table">
                  <thead class=" text-primary">
                  <tr>
                      <th>
                        User Name
                      </th>
                      <th>
                        Email ID
                      </th>
                      
                      <th class="text-center">
                          Action
                      </th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($users as $my_data)
                      <tr>
                          <td>
                           {{$my_data->name}}
                          </td>
                          <td>
                              {{$my_data->email}}
                          </td>
                          
                          <td class="text-center">
                            
                            <a href="{{ route('profile.edit') }}?user_id={{$my_data->id}}" id="update_profile" class="text-info" >Update</a> | <a href="{{ route('user.deleteuser') }}?user_id={{$my_data->id}}"  class="text-info" >Delete</a>
                          </td>
                      </tr>
                  @endforeach
                  </tbody>
              </table>

            </div>
              <div class="pagination pagination-sm"> {{$users->links()}}</div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
<div class="modal " id="register_model" tabindex="" role="dialog" aria-labelledby="searchModal" aria-hidden="true">
  <div class="modal-dialog card" role="document">
  <div class="modal-content card-body" style="background-color:inherit ">
  <div class="modal-header">
    <h4>Create New User</h4>
  </div>
  <div class="modal-body   ">
    <form class="form" class="" method="post" action="{{ route('user.createuser') }}">
      @csrf

      <div class="row">
          <div class="input-group{{ $errors->has('name') ? ' has-danger' : '' }}">
              <div class="input-group-prepend">
                  <div class="input-group-text">
                      <i class="tim-icons icon-single-02"></i>
                  </div>
              </div>
              <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}">
              @include('alerts.feedback', ['field' => 'name'])
          </div>
          <div class="input-group{{ $errors->has('email') ? ' has-danger' : '' }}">
              <div class="input-group-prepend">
                  <div class="input-group-text">
                      <i class="tim-icons icon-email-85"></i>
                  </div>
              </div>
              <input type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}">
              @include('alerts.feedback', ['field' => 'email'])
          </div>
          <div class="input-group{{ $errors->has('password') ? ' has-danger' : '' }}">
              <div class="input-group-prepend">
                  <div class="input-group-text">
                      <i class="tim-icons icon-lock-circle"></i>
                  </div>
              </div>
              <input type="password" name="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('Password') }}">
              @include('alerts.feedback', ['field' => 'password'])
          </div>
          <div class="input-group">
              <div class="input-group-prepend">
                  <div class="input-group-text">
                      <i class="tim-icons icon-lock-circle"></i>
                  </div>
              </div>
              <input type="password" name="password_confirmation" class="form-control" placeholder="{{ __('Confirm Password') }}">
          </div>
          <div class="input-group">
            <button type="submit" class="btn btn-primary ">{{ __('Create User') }}</button>
        </div>
      </div>
      
  </form>
  </div>
  </div>
  </div>
  </div>
@endsection
