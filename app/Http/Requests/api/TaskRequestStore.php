<?php

namespace App\Http\Requests\api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;

class TaskRequestStore extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function validationData()
    {
        $data = json_decode($this->getContent(), true);
    
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new HttpResponseException(
                response()->json([
                    'error' => 'Invalid JSON data',
                ], Response::HTTP_BAD_REQUEST)
            );
        }
    
        return $data;
    }

    public function rules()
    {
        return [
            'title' => ['required', 'string', 'min:2', 'max:50'],
            'description' => ['required', 'string'],
            'endDate' => ['required', 'date_format:Y-m-d'],
            'completed' => ['required', 'boolean']
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'error' => 'Validation error',
                'errors' => $validator->errors(),
            ], Response::HTTP_BAD_REQUEST)
        );
    }
}