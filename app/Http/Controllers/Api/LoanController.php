<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\LoanRepositoryInterface;
use App\Http\Requests\Loan\LoanRequest;
use App\Http\Resources\LoanResource;
use Illuminate\Http\JsonResponse;

class LoanController extends Controller
{
    public function __construct(protected LoanRepositoryInterface $loanRepository) {}

    public function index(): JsonResponse
    {
        $loans = $this->loanRepository->getAll();

        if ($loans->isEmpty()) {
            return $this->sendError('No se encontraron préstamos.');
        }

        return $this->sendResponse(
            LoanResource::collection($loans), 
            'Préstamos recuperados exitosamente.'
        );
    }

    public function show($id): JsonResponse
    {
        $loan = $this->loanRepository->findById($id);

        if (!$loan) {
            return $this->sendError('Préstamo no encontrado.');
        }

        return $this->sendResponse(
            new LoanResource($loan), 
            'Préstamo recuperado exitosamente.'
        );
    }

    public function store(LoanRequest $request): JsonResponse
    {
        $loan = $this->loanRepository->create($request->validated());

        return $this->sendResponse(
            new LoanResource($loan), 
            'Préstamo creado exitosamente.', 
            201
        );
    }

    public function update(LoanRequest $request, $id): JsonResponse
    {        
        $loan = $this->loanRepository->update($id, $request->validated());

        if (!$loan) {
            return $this->sendError('Préstamo no encontrado.');
        }

        return $this->sendResponse(
            new LoanResource($loan), 
            'Préstamo editado exitosamente.'
        );
    }

    public function destroy($id): JsonResponse
    {
        if (!$this->loanRepository->delete($id)) {
            return $this->sendError('Préstamo no encontrado.');
        }

        return $this->sendDeleteResponse('Préstamo eliminado exitosamente.');
    }
}