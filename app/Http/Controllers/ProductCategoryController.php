<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\ProductCategoryRepositoryInterface;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function __construct(protected ProductCategoryRepositoryInterface $repository)
    {
        
    }

    public function list()
    {
        $data = $this->repository->all();

        return response()->json([
            'data' => $data
        ]);
    }
}
