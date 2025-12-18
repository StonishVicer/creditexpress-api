<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Customers;

use App\Repositories\Contracts\CustomersRepositoryInterface;

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
                'message' => 'No customers found.',
                'error' => true,
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        $data = [
            'message' => 'Customers retrieved successfully.',
            'customers' => $customers,
            'error' => false,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function show($id)
    {
        $customer = $this->customersRepository->findById($id);

        if (!$customer) {
            $data = [
                'message' => 'No customer found.',
                'error' => true,
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        $data = [
            'message' => 'Customer retrieved successfully.',
            'customer' => $customer,
            'error' => false,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:255'],
            'number_id' => ['required', 'max:9'],
            'phone' => ['required', 'between:11,14'],
            'address' => 'required',
            'payment_classification' => ['required', 'in:GOOD,REGULAR,BAD'],
            'status' => ['required', 'in:ACTIVE,INACTIVE']
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

        $customer = $this->customersRepository->create([
            'name' => $request->name,
            'number_id' => $request->number_id,
            'phone' => $request->phone,
            'address' => $request->address,
            'payment_classification' => $request->payment_classification,
            'status' => $request->status,
        ]);

        if (!$customer) {
            $data = [
                'message' => 'Failed to create customer.',
                'error' => true,
                'status' => 500
            ];

            return response()->json($data, 500);
        }

        $data = [
            'message' => 'Customer created successfully.',
            'customer' => $customer,
            'error' => false,
            'status' => 201
        ];

        return response()->json($data, 201);
    }

    public function destroy($id)
    {
        $customer = $this->customersRepository->findById($id);

        if (!$customer) {
            $data = [
                'message' => 'No customer found.',
                'error' => true,
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        $this->customersRepository->delete($id);

        $data = [
            'message' => 'Customer deleted successfully.',
            'error' => false,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function update(Request $request, $id)
    {
        $customer = $this->customersRepository->findById($id);

        if (!$customer) {
            $data = [
                'message' => 'No customer found.',
                'error' => true,
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:255'],
            'number_id' => ['required', 'max:9'],
            'phone' => ['required', 'between:11,14'],
            'address' => 'required',
            'payment_classification' => ['required', 'in:GOOD,REGULAR,BAD'],
            'status' => ['required', 'in:ACTIVE,INACTIVE']
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

        $customer->name = $request->name;
        $customer->number_id = $request->number_id;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->payment_classification = $request->payment_classification;
        $customer->status = $request->status;

        $this->customersRepository->update($id, $request->all());

        $data = [
            'message' => 'Customer updated successfully.',
            'customer' => $customer,
            'error' => false,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function updatePartial(Request $request, $id)
    {
        $customer = $this->customersRepository->findById($id);

        if (!$customer) {
            $data = [
                'message' => 'No customer found.',
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
            'message' => 'Customer updated successfully.',
            'customer' => $customer,
            'error' => false,
            'status' => 200
        ];

        return response()->json($data, 200);
    }
}
