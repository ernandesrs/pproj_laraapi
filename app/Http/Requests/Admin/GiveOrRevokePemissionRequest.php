<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Models\Permission;
use Illuminate\Foundation\Http\FormRequest;

class GiveOrRevokePemissionRequest extends FormRequest
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
     * Prepeare for validation
     * @return void
     */
    public function prepareForValidation()
    {
        $this->merge([
            'permissions' => is_string($this->input('permissions')) ? collect(explode(",", $this->input('permissions'))) : null
        ]);

        return parent::prepareForValidation();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'permissions' => [
                'required',
                function ($attr, $val, $fail) {
                    $invalidPermission = $val->first(fn($permission) => Permission::where('name', '=', $permission)->count() == 0);
                    if ($invalidPermission) {
                        $fail("'{$invalidPermission}' is a invalid permission");
                    }
                }
            ]
        ];
    }
}
