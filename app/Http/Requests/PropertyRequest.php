<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PropertyRequest extends FormRequest
{
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
            'typeProperty'=> 'required|numeric',
            'listSection'=> 'required|string',
            'area'=> 'required|numeric|min:40|max:5000',
            'city' =>'required|numeric',
            'bathroom'=>'required|numeric|min:1|max:50',
            'rooms'=>'required|numeric|min:1|max:100',
            'listView'=>'required|numeric',
            'floor'=> 'required|numeric|min:0|max:100',
            'typeFinish'=> 'required|numeric',
            'location'=> 'required|string',
            'typePay'=>'required|numeric',
            'price'=>'required|numeric',
            'linkYoutube'=>'required',
            'title'=>'required:string|max:255',
            'details'=>'required:string',
        ];
    }
    public function messages(){

        return [

        ];
    }
}
