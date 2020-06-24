<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        $rules=[
            'code'=>'required|min:3|max:255',
            'name'=>'required|min:3|max:255',
            'description'=>'required|min:5',
        ];
        if($this->route()->named('categories.store')){
            $rules['code'].='|unique:categories,code';
        }
        return $rules;
    }
    public function messages()
    {
        return[
            'required'=>'Поле :attribute обязательно для ввода',
            'min'=>'Поле :attribute должно использовать :min символа',
            'code.min'=>'Поле код должно содержать не менее :min символов',
        ];
    }
}
