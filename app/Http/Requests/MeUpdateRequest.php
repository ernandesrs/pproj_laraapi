<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class MeUpdateRequest extends FormRequest
{
    use BaseRequest;

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
            'first_name' => ['required', 'string', 'min:2', 'max:25'],
            'last_name' => ['required', 'string', 'min:2', 'max:50'],
            'username' => ['required', 'string', 'unique:users,username,' . \Auth::user()->id, 'min:2', 'max:25'],
            'gender' => ['required', \Illuminate\Validation\Rule::in(User::ALLOWED_GENDERS)],
            'password' => ['nullable', 'confirmed'],
        ];
    }
}
