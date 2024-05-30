<?php

namespace App\Http\Requests\Account;

use App\Enums\UserRoles;
use App\Http\Requests\BaseRequest;
use Illuminate\Http\Request;

class CreateAccountRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return isAdminUser();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(Request $request): array
    {
        return [
            "name" => "required|string|max:100",
            "email" => "required|string|max:50|email|unique:users,email",
            "password" => "required|string|min:8",
            "confirm_password" => "required|string|max:100|same:password",
            "merchant_id" => "required|string|exists:merchants,uuid",
        ];
    }

    public function messages(): array
    {
        return [
            'password.min' => 'Password must be at least 8 characters',
        ];
    }

    public function parameters(): array
    {
        return [
            "name" => $this->input("name"),
            "email" => $this->input("email"),
            "password" => bcrypt($this->input("password")),
            // "confirm_password" => $this->input("confirm_password"),
            "merchant_id" => $this->input("merchant_id"),
            "role" => UserRoles::MERCHANT->value,
        ];
    }
}
