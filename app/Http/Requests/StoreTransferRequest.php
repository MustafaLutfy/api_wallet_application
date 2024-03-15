<?php

namespace App\Http\Requests;

use App\Enums\ExpenseCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTransferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'phone'=> ['required', 'string', 'min:11'],
            'amount'=> ['required', 'string'],
            // use php enums for fixed values not database enums , easier to add value in future features
            'category'=>['required',Rule::enum(ExpenseCategory::class)],
            'transfer_type'=> ['required', 'string']
        ];
    }

}
