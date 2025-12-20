<?php

namespace App\Repositories\Contracts;

interface LoansRepositoryInterface
{
    public function getAll();
    public function findById($id);
    public function create(array $data);
    public function delete($id);
    public function update($id, array $data);
}
