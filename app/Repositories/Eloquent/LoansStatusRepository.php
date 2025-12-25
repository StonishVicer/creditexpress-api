<?php

namespace App\Repositories\Eloquent;

use App\Models\LoansStatus;
use App\Repositories\Contracts\LoansStatusRepositoryInterface;

class LoansStatusRepository implements LoansStatusRepositoryInterface
{
    public function __construct(protected LoansStatus $loansStatus)
    {}

    public function getAll()
    {
        return $this->loansStatus->all();
    }

    public function findById($id)
    {
        return $this->loansStatus->find($id);
    }

    public function create(array $data)
    {
        return $this->loansStatus->create($data);
    }

    public function delete($id)
    {
        $loanStatus = $this->loansStatus->find($id);
        if ($loanStatus) {
            return $loanStatus->delete();
        }
    }

    public function update($id, array $data)
    {
        $loanStatus = $this->loansStatus->find($id);
        if ($loanStatus) {
            $loanStatus->update($data);
            return $loanStatus;
        }
    }
}
