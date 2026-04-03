<?php

declare(strict_types=1);

namespace Modules\Ai\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AiDescriptionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'prompt' => ['string', 'required'],
        ];
    }

    public function failedValidation(Validator ): void
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
