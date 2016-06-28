<?php

namespace CodeDelivery\Http\Requests;

use CodeDelivery\Http\Requests\Request;

class AdminCategoryRequest extends Request
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
        if($this->id != null){
            $rules = [
                'name' => 'required|max:255|min:3|unique:categories,name,'.$this->id,
            ];
        }else{
            $rules = [
                'name' => 'required|max:255|min:3|unique:categories',
            ];
        }

        return $rules;
    }
}
