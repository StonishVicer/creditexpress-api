<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\CustomerRepositoryInterface;
use App\Http\Requests\Customer\CustomerRequest;
use App\Http\Resources\CustomerResource;
use Illuminate\Http\JsonResponse;

class CustomerController extends Controller
{
    public function __construct(protected CustomerRepositoryInterface $customerRepository) {}

    public function index(): JsonResponse
    {
        $customers = $this->customerRepository->getAll();

        if ($customers->isEmpty()) {
            return $this->sendError('No se encontraron clientes.');
        }

        return $this->sendResponse(
            CustomerResource::collection($customers), 
            'Clientes recuperados exitosamente.'
        );
    }

    public function show($id): JsonResponse
    {
        $customer = $this->customerRepository->findById($id);

        if (!$customer) {
            return $this->sendError('No se encontró el cliente.');
        }

        return $this->sendResponse(
            new CustomerResource($customer), 
            'Cliente recuperado exitosamente.'
        );
    }

    public function store(CustomerRequest $request): JsonResponse
    {
        $customer = $this->customerRepository->create($request->validated());

        return $this->sendResponse(
            new CustomerResource($customer), 
            'Cliente creado exitosamente.', 
            201
        );
    }

    public function update(CustomerRequest $request, $id): JsonResponse
    {
        $customer = $this->customerRepository->update($id, $request->validated());

        if (!$customer) {
            return $this->sendError('No se encontró el cliente.');
        }

        return $this->sendResponse(
            new CustomerResource($customer), 
            'Cliente editado exitosamente.'
        );
    }

    public function destroy($id): JsonResponse
    {
        if (!$this->customerRepository->delete($id)) {
            return $this->sendError('No se encontró el cliente.');
        }
    
        return $this->sendDeleteResponse('Cliente eliminado exitosamente.');
    }
}