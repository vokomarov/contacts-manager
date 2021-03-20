<?php

namespace App\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'string|min:2|max:255',
            'lastname' => 'string|min:2|max:255',
            'email' => 'email',
            'company_name' => 'nullable|string|min:2|max:255',
            'company_job_title' => 'nullable|string|min:2|max:255',
        ];
    }
}
