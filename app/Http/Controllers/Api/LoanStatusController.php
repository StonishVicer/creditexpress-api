<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\LoanStatusRepositoryInterface;
use App\Http\Requests\Loan\LoanStatusRequest;
use App\Http\Resources\LoanStatusResource;
use Illuminate\Http\JsonResponse;

class LoanStatusController extends Controller
{    
    public function __construct(protected LoanStatusRepositoryInterface $loanStatusRepository) {}

    public function index(): JsonResponse
    {
        $statuses = $this->loanStatusRepository->getAll();

        return $statuses->isEmpty() 
            ? response()->json(['message' => 'No se encontraron estados.', 'error' => true], 404)
            : response()->json(LoanStatusResource::collection($statuses));
    }

    public function show($id): JsonResponse
    {
        $status = $this->loanStatusRepository->findById($id);

        return $status 
            ? response()->json(LoanStatusResource::make($status))
            : response()->json(['message' => 'Estado no encontrado.', 'error' => true], 404);
    }

    public function store(LoanStatusRequest $request): JsonResponse
    {
        $status = $this->loanStatusRepository->create($request->validated());

        return response()->json([
            'data' => new LoanStatusResource($status),
            'additional' => ['message' => 'Estado creado exitosamente.', 'error' => false, 'status' => 201]
        ], 201);
    }

    public function update(LoanStatusRequest $request, $id): JsonResponse
    {        
        $status = $this->loanStatusRepository->update($id, $request->validated());

        if (!$status) {
            return response()->json(['message' => 'Estado no encontrado.', 'error' => true], 404);
        }

        return response()->json([
            'data' => new LoanStatusResource($status),
            'additional' => ['message' => 'Estado actualizado exitosamente.', 'error' => false, 'status' => 200]
        ], 200);
    }

    public function destroy($id): JsonResponse
    {
        $deleted = $this->loanStatusRepository->delete($id);

        return $deleted 
            ? response()->json(['message' => 'Estado eliminado', 'error' => false], 200)
            : response()->json(['message' => 'No encontrado', 'error' => true], 404);
    }
}