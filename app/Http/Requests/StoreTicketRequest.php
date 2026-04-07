<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // For a public widget, we allow all guests
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => [
                'required',
                'regex:/^\+[1-9]\d{1,14}$/', // E.164 format
            ],
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240', // max 10MB
        ];
    }

    /**
     * Custom messages for validation errors (optional).
     */
    public function messages(): array
    {
        return [
            'phone.regex' => 'The phone number must be in international E.164 format (e.g., +123456789).',
            'file.mimes' => 'Allowed file types: jpg, jpeg, png, pdf, doc, docx.',
            'file.max' => 'Maximum file size is 10MB.',
        ];
    }
}
