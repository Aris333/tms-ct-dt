<?php

namespace TMS\ValidationRequests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLocaleRequest extends FormRequest
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
            'code' => [
                'sometimes',
                'string',
                'max:10',
                Rule::unique('locales', 'code')->ignore($this->route('locale')),
            ],
            'name' => 'sometimes|string|max:100',
        ];
    }
    public function prepareRequest()
    {
        $request = $this;

        return [
            'name' => $request['name'],
            'code' => $request['code'],
        ];
    }
}
