<?php namespace App\Http\Requests\User;

use App\Http\Requests\Request;
use Auth;

class Update extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'alias' => 'unique:users,alias,' . Auth::user()->id,
            'email' => 'email|unique:users,email,' . Auth::user()->id,
            'password' => 'required'
        ];
    }
}
