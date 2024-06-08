<?php

namespace App\Http\Controllers;

use App\Http\Requests\Merchant\CreateFormMerchantRequest;
use App\Http\Requests\Merchant\CreateMerchantRequest;
use App\Http\Requests\Merchant\GetMerchantRequest;
use App\Http\Requests\Merchant\SelectMerchantRequest;
use App\Http\Requests\Merchant\UpdateMerchantRequest;
use App\Repositories\Contracts\MerchantRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class MerchantController extends Controller
{
    public function __construct(protected MerchantRepositoryInterface $repository)
    {
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index(GetMerchantRequest $request)
    {
        $query = $this->repository;

        if (!empty($search = $request->search())) {
            $query->where(function ($query) use($search) {
                $query->where("company_tax_id", "LIKE", "%$search%")
                    ->orWhere('company_name', "LIKE", "%$search%")
                    ->orWhere('contact_number', "LIKE", "%$search%")
                    ->orWhere('address', "LIKE", "%$search%")
                    ->orWhere('city', "LIKE", "%$search%")
                    ->orWhere('country', "LIKE", "%$search%")
                    ->orWhere('postal_code', "LIKE", "%$search%");
            });
        }

        $data = $query->paginate($request->size ?? 5, [], [], [], true);
        return Inertia::render('Admin/Merchant/MerchantList', [
            'paginate' => $data,
            'state' => 'create'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(CreateFormMerchantRequest $request)
    {
        return Inertia::render("Admin/Merchant/MerchantForm");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateMerchantRequest $request)
    {
        $merchant = $this->repository->create($request->parameters());

        return redirect()->back()
            ->with('code', '200')
            ->with('status', 'success')
            ->with('message', 'Merchant submitted successfully!')
            ->with('data', $merchant);
    }

    /**
     * Display the specified resource.
     */
    public function show(SelectMerchantRequest $request, string $uuid)
    {
        $merchant = $this->repository->findByUuid($uuid, ['merchantUser', 'merchantUser.user'], ['products']);
        return Inertia::render("Admin/Merchant/MerchantForm", [
            'data' => $merchant,
            'state' => 'update'
        ]);
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
    public function update(UpdateMerchantRequest $request, string $uuid)
    {
        $merchant = $this->repository->update($uuid, $request->parameters());

        return redirect()->back()
            ->with('code', '200')
            ->with('status', 'success')
            ->with('message', 'Merchant updated successfully!')
            ->with('data', $merchant);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uuid)
    {
        $merchant = $this->repository->delete($uuid);

        return Redirect()->route('admin.merchants.index')
            ->with('code', '200')
            ->with('status', 'success')
            ->with('message', 'Merchant deleted successfully!')
            ->with('data', $merchant);
    }

    public function list()
    {
        $data = $this->repository->all();
        return response()->json([
            "data" => $data
        ]);
    }

    public function search(Request $request)
    {
        $search = $request->search;
        $data = null;
        if (!empty($search)) {
            $filter = function($query) use($search) {
                $query->where('company_name', "LIKE", "%{$search}%")->orWhere('company_tax_id', "LIKE", "%{$search}%");
            };

            $data = $this->repository->apiSearch($filter);
        }

        return response()->json([
            "data" => $data
        ]);
    }
}
