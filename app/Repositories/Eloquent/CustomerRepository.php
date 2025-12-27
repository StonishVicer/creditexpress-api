<?php

namespace App\Repositories\Eloquent;

use App\Models\Customer;
use App\Repositories\Contracts\CustomerRepositoryInterface;

class CustomerRepository implements CustomerRepositoryInterface
{
    public function __construct(protected Customer $customer)
    {}

    public function getAll()
    {
        return $this->customer->all();
    }

    public function findById($id)
    {
        return $this->customer->find($id);
    }

    public function create(array $data)
    {
        return $this->customer->create($data);
    }

    public function delete($id)
    {
        $customer = $this->customer->find($id);
        if ($customer) {
            return $customer->delete();
        }
    }

    public function update($id, array $data)
    {
        $customer = $this->customer->find($id);
        if ($customer) {
            $customer->update($data);
            return $customer;
        }
    }

    public function updatePartial($id, array $data)
    {
        $customer = $this->customer->find($id);
        if ($customer) {
            $customer->fill($data);
            $customer->save();
            return $customer;
        }
    }
}
