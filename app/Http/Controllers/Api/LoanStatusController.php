<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\LoanStatus;
use App\Repositories\Contracts\LoanStatusRepositoryInterface;
use App\Http\Requests\LoanStatusRequest;
use App\Http\Resources\LoanStatusResource;

class LoanStatusController extends Controller
{
    public function __construct(protected LoanStatusRepositoryInterface $loanStatusRepository)
    {
        $this->loanStatusRepository = $loanStatusRepository;
    }

    public function index()
    {
        $loan_status = $this->loanStatusRepository->getAll();

        if ($loan_status->isEmpty()) {
            $data = [
                'message' => 'No se encontraron estados de prestamos.',
                'error' => true,
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        return LoanStatusResource::collection($loan_status);
    }

    public function show($id)
    {
        $loan_status = $this->loanStatusRepository->findById($id);

        if (!$loan_status) {
            $data = [
                'message' => 'Estado de prestamo no encontrado.',
                'error' => true,
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        return LoanStatusResource::make($loan_status);
    }

    public function store(LoanStatusRequest $request)
    {
        $loan_status = $this->loanStatusRepository->create($request->validated());

        if (!$loan_status) {
            $data = [
                'message' => 'Error al crear el estado de prestamo.',
                'error' => true,
                'status' => 500
            ];

            return response()->json($data, 500);
        }

        return (new LoanStatusResource($loan_status))
            ->additional([
                'message' => 'Estado de prestamo creado exitosamente.',
                'error' => false,
                'status' => 201
            ])
            ->response()
            ->setStatusCode(201);
    }

    public function update(LoanStatusRequest $request, $id) // Usar LoanStatusRequest
    {
        $status = $this->loanStatusRepository->findById($id);

        if (!$status) {
            return response()->json(['message' => 'No encontrado', 'error' => true], 404);
        }

        $updated = $this->loanStatusRepository->update($id, $request->validated());

        return (new LoanStatusResource($updated))
            ->additional(['message' => 'Estado actualizado', 'error' => false, 'status' => 200]);
    }

    public function destroy($id)
    {
        $status = $this->loanStatusRepository->findById($id);

        if (!$status) {
            return response()->json(['message' => 'No encontrado', 'error' => true], 404);
        }

        $this->loanStatusRepository->delete($id);

        return response()->json(['message' => 'Estado eliminado', 'error' => false], 200);
    }
}
