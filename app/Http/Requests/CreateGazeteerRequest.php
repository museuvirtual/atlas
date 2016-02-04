<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use Auth;

class CreateGazeteerRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
            'longitude_deg' => 'required|numeric',
            'longitude_min' => 'required|numeric',
            'longitude_sec' => 'required|numeric',
            'latitude_deg' => 'required|numeric',
            'latitude_min' => 'required|numeric',
            'latitude_sec' => 'required|numeric',
            //Unique locality name for each Users Gazeteer
            'locality_name' => 'required|min:3|unique:gazeteers,locality_name,NULL,id,user_id,'.Auth::id()

		];
	}

}
