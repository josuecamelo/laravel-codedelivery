<?php

namespace CodeDelivery\Http\Requests;

use CodeDelivery\Http\Requests\Request;
use Illuminate\Http\Request as HttpRequest; //evitando conflito com Default Request

class CheckoutRequest extends Request
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
    /*public function rules()
    {
        return [
            'cupom_code' => 'exists:cupoms.code,used,0',//se existe o cupom e se não está usado,

        ];
    }*/
    public function rules(HttpRequest $request)
    {
        $rules = [
            'cupom_code' => 'exists:cupoms,code,used,0'//se existe o cupom e se não está usado, verifica se existe só se for passado
        ];

        // Obriga a inserir pelo menos um item
        $this->buildRulesItems(0, $rules);

        $items = $request->get('items', []);
        $items = !is_array($items) ? [] : $items;

        // Adiciona regras para a quantidade de items
        foreach ($items as $key => $item) {
            $this->buildRulesItems($key, $rules);
        }

        return $rules;
    }

    public function buildRulesItems($key, array &$rules)
    {
        $rules["items.$key.product_id"] = 'required';
        $rules["items.$key.qtd"] = 'required';
    }
}
