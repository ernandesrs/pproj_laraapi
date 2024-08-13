<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UserFormRequest extends FormRequest
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
        $rules = [
            'first_name' => ['required', 'string', 'min:2', 'max:25'],
            'last_name' => ['required', 'string', 'min:2', 'max:50'],
            'gender' => ['required', \Illuminate\Validation\Rule::in(User::ALLOWED_GENDERS)]
        ];

        $rules = [
            ...$rules,
            ...(isset($this->user->id) ? [
                'username' => ['required', 'string', 'min:2', 'max:25', 'unique:users,username,' . $this->user->id],
                'password' => ['nullable', 'string', 'confirmed']
            ] : [
                'username' => ['required', 'string', 'min:2', 'max:25', 'unique:users,username'],
                'email' => ['required', 'email', 'unique:users,email'],
                'password' => ['required', 'string', 'confirmed'],
                'send_verification_mail' => ['nullable', 'boolean']
            ])
        ];

        return $rules;
    }
}
