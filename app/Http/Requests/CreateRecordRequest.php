<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateRecordRequest extends Request {

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
            'localidades'=> 'required',
            'basis_of_record'=> 'required',
            'date_observed'=> 'required|date',
            'photo_1'=>'required|between:20,3000|mimes:jpeg',
            'photo_2'=>'between:20,2000|mimes:jpeg',
            'photo_3'=>'between:20,2000|mimes:jpeg'

		];
	}

}
