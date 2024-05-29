<?php

namespace App\Http\Requests\Product;

use App\Enums\ProductUnits;
use App\Enums\StockStatus;
use App\Http\Requests\BaseRequest;
use Illuminate\Http\Request;

class UpdateProductRequest extends BaseRequest
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
            "sku" => "required|string|max:100|unique:products,sku,$request->product,uuid",
            "brand_name" => "required|string|max:255",
            "product_name" => "required|string|max:255",
            "product_description" => "required|string|max:255",
            "price" => "required|decimal:2",
            "sale_price" => "required|decimal:2",
            // "is_sale" => "required|boolean",
            // "quantity" => "required|integer",
            // "sale" => "required|string|max:255", sales quantity (auto compute)
            "stock_status" => "required|in:" . implode(",", StockStatus::values()),
            "stock_quantity" => "required|integer",
            // "sold_quantity" => "required|string|max:255", sold quantity (auto compute)
            "unit" => "required|in:" . implode(",", ProductUnits::values()),
            // "start_date" => "required|date",
            "size" => "required|string|max:100",
            "weight" => "required|string|max:100",
            // "rate" => "required|integer|max:10",
            "category_id" => "required|string|exists:product_categories,uuid",
            "merchant_id" => "required|string|exists:merchants,uuid",
        ];
    }

    public function parameters(): array
    {
        return [
            "sku" => $this->input("sku"),
            "brand_name" => $this->input("brand_name"),
            "product_name" => $this->input("product_name"),
            "product_description" => $this->input("product_description"),
            "price" => $this->input("price"),
            "sale_price" => $this->input("sale_price"),
            "stock_status" => $this->input("stock_status"),
            "stock_quantity" => $this->input("stock_quantity"),
            "unit" => $this->input("unit"),
            "size" => $this->input("size"),
            "weight" => $this->input("weight"),
            "category_id" => $this->input("category_id"),
            "merchant_id" => $this->input("merchant_id"),
            "quantity" => $this->input("stock_quantity"),
            "start_date" => Date("Y-m-d"),
        ];
    }
}
