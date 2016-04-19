<?php namespace App\Http\Requests\Follower;

use App\Http\Requests\Request;
use Auth;

class UnFollow extends Request
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
            'summonerId' => 'required|exists:summoners,summonerId',
            'region'     => 'required|region',
        ];
    }
}
