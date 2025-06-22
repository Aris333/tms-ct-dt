<?php

namespace TMS\ValidationRequests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTranslationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'key' => 'sometimes|string|max:255',
            'key_description' => 'sometimes|string|max:500',
            'locale_code' => 'sometimes|string|max:10|exists:locales,code',
            'value' => 'sometimes|string',
            'tags' => 'sometimes|array',
            'tags.*' => 'string|max:50',
        ];
    }
    public function prepareRequest()
    {
        $request = $this;

        return [
            'key' => $request['key'],
            'key_description' => $request['key_description'],
            'locale_code' => $request['locale_code'],
            'value' => $request['value'],
            'tags' => $request['tags'],
        ];
    }
}
