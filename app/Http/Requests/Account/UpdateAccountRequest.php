<?php

namespace App\Http\Requests\Account;

use App\Http\Requests\BaseRequest;
use Illuminate\Http\Request;

class UpdateAccountRequest extends BaseRequest
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
            "email" => "required|string|max:50|email|unique:users,email,$request->account,uuid",
            "password" => "required|string|max:100",
            "confirm_password" => "required|string|max:100|same:password",
            "merchant_id" => "required|string|exists:merchants,uuid",
        ];
    }

    public function parameters(): array
    {
        return [
            "email" => $this->input("email"),
            "password" => $this->input("password"),
            "confirm_password" => $this->input("confirm_password"),
            "merchant_id" => $this->input("merchant_id"),
        ];
    }
}
