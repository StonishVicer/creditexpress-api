<?php
namespace App\Repositories\Eloquent;

use App\Models\Loan; // Corregido a singular
use App\Repositories\Contracts\LoanRepositoryInterface;

class LoanRepository implements LoanRepositoryInterface
{
    public function __construct(protected Loan $loan) {} // Corregido

    public function getAll() { return $this->loan->all(); }
    public function findById($id) { return $this->loan->find($id); }
    public function create(array $data) { return $this->loan->create($data); }
    public function delete($id) {
        $loan = $this->findById($id);
        return $loan ? $loan->delete() : false;
    }
    public function update($id, array $data) {
        $loan = $this->findById($id);
        if ($loan) {
            $loan->update($data);
            return $loan;
        }
        return null;
    }
}
