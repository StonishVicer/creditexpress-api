<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Customers;
use App\Repositories\Contracts\CustomersRepositoryInterface;
use App\Http\Requests\CustomersRequest;
use App\Http\Resources\CustomersResource;

class CustomersController extends Controller
{
    public function __construct(protected CustomersRepositoryInterface $customersRepository)
    {
        $this->customersRepository = $customersRepository;
    }

    public function index()
    {
        $customers = $this->customersRepository->getAll();

        if ($customers->isEmpty()) {
            $data = [
                'message' => 'No se encontraron clientes.',
                'error' => true,
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        return CustomersResource::collection($customers);
    }

    public function show($id)
    {
        $customer = $this->customersRepository->findById($id);

        if (!$customer) {
            $data = [
                'message' => 'No se encontro el cliente.',
                'error' => true,
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        return CustomersResource::make($customer);
    }

    public function store(CustomersRequest $request)
    {
        $customer = $this->customersRepository->create($request->validated());

        if (!$customer) {
            $data = [
                'message' => 'Error al crear el cliente.',
                'error' => true,
                'status' => 500
            ];

            return response()->json($data, 500);
        }

        return (new CustomersResource($customer))
            ->additional([
                'message' => 'Cliente creado exitosamente.',
                'error' => false,
                'status' => 201
            ])
            ->response()
            ->setStatusCode(201);
    }

    public function destroy($id)
    {
        $customer = $this->customersRepository->findById($id);

        if (!$customer) {
            $data = [
                'message' => 'No se encontro el cliente.',
                'error' => true,
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        $this->customersRepository->delete($id);

        $data = [
            'message' => 'Cliente eliminado exitosamente.',
            'error' => false,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function update(CustomersRequest $request, $id)
    {
        $customer = $this->customersRepository->findById($id);

        if (!$customer) {
            $data = [
                'message' => 'No se encontro el cliente.',
                'error' => true,
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        $updatedCustomer = $this->customersRepository->update($id, $request->validated());

        return (new CustomersResource($updatedCustomer))
            ->additional([
                'message' => 'Cliente editado exitosamente.',
                'error' => false,
                'status' => 200
            ])
            ->response()
            ->setStatusCode(200);
    }

    public function updatePartial(Request $request, $id)
    {
        $customer = $this->customersRepository->findById($id);

        if (!$customer) {
            $data = [
                'message' => 'No se encontro el cliente.',
                'error' => true,
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'max:255',
            'number_id' => 'max:9',
            'phone' => 'between:11,14',
            'address' => 'max:255',
            'payment_classification' => 'in:GOOD,REGULAR,BAD',
            'status' => 'in:ACTIVE,INACTIVE'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Validation errors',
                'errors' => $validator->errors(),
                'error' => true,
                'status' => 422
            ];

            return response()->json($data, 422);
        }

        if ($request->has('name')) {
            $customer->name = $request->name;
        }
        if ($request->has('number_id')) {
            $customer->number_id = $request->number_id;
        }
        if ($request->has('phone')) {
            $customer->phone = $request->phone;
        }
        if ($request->has('address')) {
            $customer->address = $request->address;
        }
        if ($request->has('payment_classification')) {
            $customer->payment_classification = $request->payment_classification;
        }
        if ($request->has('status')) {
            $customer->status = $request->status;
        }

        $this->customersRepository->updatePartial($id, $request->all());

        $data = [
            'message' => 'Cliente editado exitosamente.',
            'customer' => $customer,
            'error' => false,
            'status' => 200
        ];

        return response()->json($data, 200);
    }
}
