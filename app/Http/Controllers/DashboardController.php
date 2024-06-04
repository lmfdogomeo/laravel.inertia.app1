<?php

namespace App\Http\Controllers;

use App\Enums\UserRoles;
use App\Http\Requests\Dashboard\GetTotalMerchantRequest;
use App\Http\Requests\Dashboard\GetTotalProductRequest;
use App\Http\Requests\Dashboard\GetTotalUserRequest;
use App\Repositories\Contracts\AccountRepositoryInterface;
use App\Repositories\Contracts\MerchantRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct(
        protected AccountRepositoryInterface $accountRepository,
        protected ProductRepositoryInterface $productRepository,
        protected MerchantRepositoryInterface $merchantRepository,
    ){
        
    }

    public function getTotalUser(GetTotalUserRequest $request)
    {
        $data = $this->accountRepository->count();
        return $data;
    }

    public function getTotalMerchant(GetTotalMerchantRequest $request)
    {
        $data = $this->merchantRepository->count();
        return $data;
    }

    public function getTotalProduct(GetTotalProductRequest $request)
    {
        $data = $this->productRepository->count();
        return $data;
    }

    public function getDataProductByYear()
    {
        $year = Date("Y");
        $merchantId = null;
        if (auth()->user()->role->is(UserRoles::MERCHANT)) {
            $merchantId = auth()->user()->merchantUser->merchant->id;
            // $data = $this->productRepository->dataPerMonthByYear($year, $merchantId);
        }
        // else {
        //     $data = $this->productRepository->dataPerMonthByYear($year);
        // }
        
        $data = $this->productRepository->dataPerMonthByYear($year, $merchantId);

        return $data;
    }

    public function getDataMerchantByYear()
    {
        $year = Date("Y");
        $data = $this->merchantRepository->dataPerMonthByYear($year);

        return $data;
    }

    public function getDataUserByYear()
    {
        $year = Date("Y");
        $data = $this->accountRepository->dataPerMonthByYear($year);

        return $data;
    }
}
