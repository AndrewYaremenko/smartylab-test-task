<?php

namespace App\Http\Requests\api;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequestUpdate extends FormRequest
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

    public function validationData()
    {
        return json_decode($this->getContent(), true);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required', 'string', 'min:2', 'max:50'],
            'description' => ['string'],
            'endDate' => ['required','date_format:Y-m-d'],
            'completed' => ['boolean']
        ];
    }
}
