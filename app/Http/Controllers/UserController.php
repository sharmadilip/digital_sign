<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
        return view('users.index', ['users' => $model->paginate(15)]);
    }
    public function userlsit(User $model)  {
        return view('users.index', ['users' => $model->paginate(15)]);
    }
    public function create_new_user(UserRequest $userRequest)
    {   
        $data=$userRequest->all();
        $user= User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        return back()->withStatus(__('User has been created')); 
    }
    public function delete_user_data(Request $userRequest)
    { 
        if(auth()->user()->role_as==1)
        {
      $user_request=$userRequest->all();
      $user = User::find($user_request['user_id']);    
       $user->forceDelete();
       return back()->withStatus(__('User has been Deleted.'));
        }
        else{
            return back()->withStatus(__('You dont have permission to do that.'));  
        }
    }
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
}
