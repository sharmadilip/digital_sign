<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Client\Request;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(auth()->user()->role_as==1)
        {
            return true;
        }
        else{
        return auth()->check();
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(FormRequest $request)
    {   $user_id=$request->input('user_id');
       
        if(auth()->user()->role_as==1)
        {
            return [
                'name' => ['required', 'min:3'],
                'email' => ['required', 'email', Rule::unique((new User)->getTable())->ignore(User::find($user_id)->id)],
            ];
        }
        else{
       
        return [
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique((new User)->getTable())->ignore(auth()->id())],
        ];
    }
    }
}
