<?php

namespace App\Repositories\Contracts;

interface CustomersRepositoryInterface
{
    public function getAll();
    public function findById($id);
    public function create(array $data);
    public function delete($id);
    public function update($id, array $data);
    public function updatePartial($id, array $data);
}
