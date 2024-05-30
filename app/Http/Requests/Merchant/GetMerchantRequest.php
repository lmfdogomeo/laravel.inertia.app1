<?php

namespace App\Http\Requests\Merchant;

use App\Http\Requests\BaseRequest;
use Illuminate\Http\Request;

class GetMerchantRequest extends BaseRequest
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
            //
        ];
    }

    public function search(): string
    {
        return $this->query("search") ?? "";
    }
}
