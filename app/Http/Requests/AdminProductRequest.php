<?php

namespace CodeDelivery\Http\Requests;

use CodeDelivery\Http\Requests\Request;

class AdminProductRequest extends Request
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
                'name' => 'required|max:255|min:3|unique:products,name,'.$this->id,
                'description' => 'required',
                'price' => 'required',
                'category_id' => 'required|not_in: 0,"", null',
            ];
        }else{
            $rules = [
                'name' => 'required|max:255|min:3|unique:products',
                'description' => 'required',
                'price' => 'required',
                'category_id' => 'required|not_in: 0,"", null',
            ];
        }

        return $rules;
    }
}
