<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\CustomerRepositoryInterface;
use App\Http\Requests\Customer\CustomerRequest;
use App\Http\Resources\CustomerResource;
use Illuminate\Http\JsonResponse;

class CustomerController extends Controller
{
    public function __construct(protected CustomerRepositoryInterface $customerRepository)
    {}

    public function index(): \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $customers = $this->customerRepository->getAll();

        if ($customers->isEmpty()) {
            return response()->json([
                'message' => 'No se encontraron clientes.',
                'error' => true,
                'status' => 404
            ], 404);
        }

        return CustomerResource::collection($customers);
    }

    public function show($id): JsonResponse|CustomerResource
    {
        $customer = $this->customerRepository->findById($id);

        if (!$customer) {
            return response()->json([
                'message' => 'No se encontro el cliente.',
                'error' => true,
                'status' => 404
            ], 404);
        }

        return CustomerResource::make($customer);
    }

    public function store(CustomerRequest $request): \Illuminate\Http\JsonResponse
    {
        $customer = $this->customerRepository->create($request->validated());
 
        return response()->json([
            'data' => new CustomerResource($customer),
            'additional' => [
                'message' => 'Cliente creado exitosamente.',
                'error' => false,
                'status' => 201
            ]
        ], 201);
    }

    public function update(CustomerRequest $request, $id): JsonResponse
    {
        $customer = $this->customerRepository->findById($id);

        if (!$customer) {
            return response()->json([
                'message' => 'No se encontro el cliente.',
                'error' => true,
                'status' => 404
            ], 404);
        }

        $updatedCustomer = $this->customerRepository->update($id, $request->validated());

        return (new CustomerResource($updatedCustomer))
            ->additional([
                'message' => 'Cliente editado exitosamente.',
                'error' => false,
                'status' => 200
            ])
            ->response()
            ->setStatusCode(200);
    }

    public function updatePartial(CustomerRequest $request, $id): JsonResponse
    {
        $customer = $this->customerRepository->findById($id);

        if (!$customer) {
            return response()->json([
                'message' => 'No se encontro el cliente.',
                'error' => true,
                'status' => 404
            ], 404);
        }

        // Al usar CustomerRequest, los datos ya vienen validados (con 'sometimes' para PATCH)
        $updatedCustomer = $this->customerRepository->updatePartial($id, $request->validated());

        return (new CustomerResource($updatedCustomer))
            ->additional([
                'message' => 'Cliente editado exitosamente.',
                'error' => false,
                'status' => 200
            ])
            ->response()
            ->setStatusCode(200);
    }

    public function destroy($id): JsonResponse
    {
        $customer = $this->customerRepository->findById($id);

        if (!$customer) {
            return response()->json([
                'message' => 'No se encontro el cliente.',
                'error' => true,
                'status' => 404
            ], 404);
        }

        $this->customerRepository->delete($id);

        return response()->json([
            'message' => 'Cliente eliminado exitosamente.',
            'error' => false,
            'status' => 200
        ], 200);
    }
}