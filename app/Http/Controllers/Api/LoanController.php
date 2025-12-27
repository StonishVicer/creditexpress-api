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

        return $loans->isEmpty()
            ? response()->json(['message' => 'No se encontraron préstamos.', 'error' => true], 404)
            : response()->json(LoanResource::collection($loans));
    }

    public function show($id): JsonResponse
    {
        $loan = $this->loanRepository->findById($id);

        return $loan
            ? response()->json(LoanResource::make($loan))
            : response()->json(['message' => 'Préstamo no encontrado.', 'error' => true], 404);
    }

    public function store(LoanRequest $request): JsonResponse
    {
        $loan = $this->loanRepository->create($request->validated());

        return response()->json([
            'data' => new LoanResource($loan),
            'additional' => ['message' => 'Préstamo creado exitosamente.', 'error' => false, 'status' => 201]
        ], 201);
    }

    public function update(LoanRequest $request, $id): JsonResponse
    {        
        $loan = $this->loanRepository->update($id, $request->validated());

        if (!$loan) {
            return response()->json(['message' => 'Préstamo no encontrado.', 'error' => true], 404);
        }

        return response()->json([
            'data' => new LoanResource($loan),
            'additional' => ['message' => 'Préstamo editado exitosamente.', 'error' => false, 'status' => 200]
        ], 200);
    }

    public function destroy($id): JsonResponse
    {
        $deleted = $this->loanRepository->delete($id);

        return $deleted 
            ? response()->json(['message' => 'Préstamo eliminado exitosamente.', 'error' => false, 'status' => 200], 200)
            : response()->json(['message' => 'Préstamo no encontrado.', 'error' => true, 'status' => 404], 404);
    }
}