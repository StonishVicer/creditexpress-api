<?php

namespace App\Repositories\Contracts;

interface LoanRepositoryInterface
{
    public function getAll();
    public function findById($id);
    public function create(array $data);
    public function delete($id);
    public function update($id, array $data);
}
