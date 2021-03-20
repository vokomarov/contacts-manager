<?php

namespace App\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:2|max:255',
            'lastname' => 'required|string|min:2|max:255',
            'email' => 'required|email',
            'company_name' => 'nullable|string|min:2|max:255',
            'company_job_title' => 'nullable|string|min:2|max:255',
        ];
    }
}
