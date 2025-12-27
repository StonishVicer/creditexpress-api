<?php

namespace App\Repositories\Contracts;

interface LoanStatusRepositoryInterface
{
    public function getAll();
    public function findById($id);
    public function create(array $data);
    public function delete($id);
    public function update($id, array $data);
}
