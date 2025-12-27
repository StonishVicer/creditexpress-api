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

        return $customers->isEmpty() 
            ? response()->json(['message' => 'No se encontraron clientes.', 'error' => true], 404)
            : response()->json(CustomerResource::collection($customers));
    }

    public function show($id): JsonResponse
    {
        $customer = $this->customerRepository->findById($id);

        return $customer 
            ? response()->json(CustomerResource::make($customer))
            : response()->json(['message' => 'No se encontró el cliente.', 'error' => true], 404);
    }

    public function store(CustomerRequest $request): JsonResponse
    {
        $customer = $this->customerRepository->create($request->validated());
 
        return response()->json([
            'data' => new CustomerResource($customer),
            'additional' => ['message' => 'Cliente creado exitosamente.', 'error' => false, 'status' => 201]
        ], 201);
    }

    public function update(CustomerRequest $request, $id): JsonResponse
    {
        $customer = $this->customerRepository->update($id, $request->validated());

        if (!$customer) {
            return response()->json(['message' => 'No se encontró el cliente.', 'error' => true], 404);
        }

        return response()->json([
            'data' => new CustomerResource($customer),
            'additional' => ['message' => 'Cliente editado exitosamente.', 'error' => false, 'status' => 200]
        ], 200);
    }

    public function destroy($id): JsonResponse
    {
        $deleted = $this->customerRepository->delete($id);

        return $deleted 
            ? response()->json(['message' => 'Cliente eliminado exitosamente.', 'error' => false, 'status' => 200], 200)
            : response()->json(['message' => 'No se encontró el cliente.', 'error' => true, 'status' => 404], 404);
    }
}