<?php

namespace App\Repositories\Eloquent;

use App\Models\Loans;
use App\Repositories\Contracts\LoansRepositoryInterface;

class LoansRepository implements LoansRepositoryInterface
{
    public function __construct(protected Loans $loans)
    {}

    public function getAll()
    {
        return $this->loans->all();
    }

    public function findById($id)
    {
        return $this->loans->find($id);
    }

    public function create(array $data)
    {
        return $this->loans->create($data);
    }

    public function delete($id)
    {
        $loan = $this->loans->find($id);
        if ($loan) {
            return $loan->delete();
        }
    }

    public function update($id, array $data)
    {
        $loan = $this->loans->find($id);
        if ($loan) {
            $loan->update($data);
            return $loan;
        }
    }
}
