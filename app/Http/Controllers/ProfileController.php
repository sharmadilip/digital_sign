<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit(Request $request)
    {   $user_req=$request->all();
        $user_id= $user_req['user_id'];
        $my_data['user_data']=User::find($user_id);
        return view('profile.edit',$my_data);
    }

    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileRequest $request)
    {   $user_req=$request->all();
        $user_id= $user_req['user_id'];
       
        if(auth()->user()->role_as==1)
        {
           User::find($user_id)->update($request->all());
        }
        else{
            auth()->user()->update($request->all());
        }
        return back()->withStatus(__('Profile successfully updated.'));
    }

    /**
     * Change the password
     *
     * @param  \App\Http\Requests\PasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(PasswordRequest $request)
    {
        $user_req=$request->all();
        $user_id= $user_req['user_id'];
       
        if(auth()->user()->role_as==1)
        {
           User::find($user_id)->update(['password' => Hash::make($request->get('password'))]);
        }
        else{
            auth()->user()->update(['password' => Hash::make($request->get('password'))]);
        }
       

        return back()->withPasswordStatus(__('Password successfully updated.'));
    }
}
