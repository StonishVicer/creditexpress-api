<?php

namespace App\Repositories\Eloquent;

use App\Models\Customers;
use App\Repositories\Contracts\CustomersRepositoryInterface;

class CustomersRepository implements CustomersRepositoryInterface
{
    public function __construct(protected Customers $customers)
    {}

    public function getAll()
    {
        return $this->customers->all();
    }

    public function findById($id)
    {
        return $this->customers->find($id);
    }

    public function create(array $data)
    {
        return $this->customers->create($data);
    }

    public function delete($id)
    {
        $customer = $this->customers->find($id);
        if ($customer) {
            return $customer->delete();
        }
    }

    public function update($id, array $data)
    {
        $customer = $this->customers->find($id);
        if ($customer) {
            $customer->update($data);
            return $customer;
        }
    }

    public function updatePartial($id, array $data)
    {
        $customer = $this->customers->find($id);
        if ($customer) {
            $customer->fill($data);
            $customer->save();
            return $customer;
        }
    }
}
