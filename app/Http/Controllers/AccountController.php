<?php

namespace App\Http\Controllers;

use App\Http\Requests\Account\CreateAccountRequest;
use App\Http\Requests\Account\GetAccountRequest;
use App\Repositories\Contracts\AccountRepositoryInterface;
use App\Repositories\Contracts\MerchantRepositoryInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AccountController extends Controller
{
    public function __construct(protected AccountRepositoryInterface $repository, protected MerchantRepositoryInterface $merchantRepository)
    {
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index(GetAccountRequest $request)
    {
        $data = $this->repository->paginate($request->size ?? 5, [], ['merchantUser', 'merchantUser.merchant']);
        return Inertia::render('Admin/Account/AccountList', [
            'paginate' => $data,
            'state' => 'index'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(CreateAccountRequest $request)
    {
        return Inertia::render("Admin/Account/AccountForm", [
            "state" => "create",
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateAccountRequest $request)
    {
        $merchant = $this->merchantRepository->findByUuid($request->merchant_id);

        $request->merge([
            'merchant_id' => $merchant->id
        ]);

        $account = $this->repository->create($request->parameters());

        return redirect()->back()
            ->with('code', '200')
            ->with('status', 'success')
            ->with('message', 'Account created successfully!')
            ->with('data', $account);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
