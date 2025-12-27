<?php
namespace App\Repositories\Eloquent;

use App\Models\LoanStatus; // Importar correctamente
use App\Repositories\Contracts\LoanStatusRepositoryInterface;

class LoanStatusRepository implements LoanStatusRepositoryInterface
{
    public function __construct(protected LoanStatus $loanStatus){}

    public function getAll(){ return $this->loanStatus->all(); }

    public function findById($id){ return $this->loanStatus->find($id); }    

    public function create(array $data){ return $this->loanStatus->create($data); }    

    public function delete($id){
        $status = $this->findById($id);
        return $status ? $status->delete() : false;
    }

    public function update($id, array $data)
    {
        $status = $this->findById($id);
        if ($status) {
            $status->update($data);
            return $status;
        }
        return null;
    }
}