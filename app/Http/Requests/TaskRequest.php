<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        if ($this->method() == 'POST') {
            return [
                'name'          => 'required|string|min:3|max:255',
                'description'   => 'string',
                'status'        => 'required|string|min:3|max:25|in:backlog,in_progress,waiting_customer_approval,approved',
                'file_url'      => 'required|string'
            ];
        }

        if ($this->method() == 'PUT' || $this->method() == 'PATCH') {
            return [
                'name'          => 'string|min:3|max:255',
                'description'   => 'string',
                'status'        => 'string|min:3|max:25|in:backlog,in_progress,waiting_customer_approval,approved',
                'file_url'      => 'string'
            ];
        }
    }

    // adicionar tratamento para remover os espaços em branco
    
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'status.in'             => 'O status deve ser um dos seguintes: backlog, in_progress, waiting_customer_approval, approved'
        ];
    }
        
}
