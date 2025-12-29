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

        if ($statuses->isEmpty()) {
            return $this->sendError('No se encontraron estados.');
        }

        return $this->sendResponse(
            LoanStatusResource::collection($statuses), 
            'Estados recuperados exitosamente.'
        );
    }

    public function show($id): JsonResponse
    {
        $status = $this->loanStatusRepository->findById($id);

        if (!$status) {
            return $this->sendError('Estado no encontrado.');
        }

        // Antes: Devolvía el recurso directo
        return $this->sendResponse(
            new LoanStatusResource($status), 
            'Estado recuperado exitosamente.'
        );
    }

    public function store(LoanStatusRequest $request): JsonResponse
    {
        $status = $this->loanStatusRepository->create($request->validated());

        return $this->sendResponse(
            new LoanStatusResource($status), 
            'Estado creado exitosamente.', 
            201
        );
    }

    public function update(LoanStatusRequest $request, $id): JsonResponse
    {
        $status = $this->loanStatusRepository->update($id, $request->validated());
    
        if (!$status) {
            return $this->sendError('Estado no encontrado.');
        }
    
        return $this->sendResponse(
            new LoanStatusResource($status), 
            'Estado actualizado exitosamente.'
        );
    }

    public function destroy($id): JsonResponse
    {
        if (!$this->loanStatusRepository->delete($id)) {
            return $this->sendError('Estado no encontrado.');
        }

        return $this->sendDeleteResponse('Estado eliminado exitosamente.');
    }
}