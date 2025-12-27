<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Contracts\LoanRepositoryInterface;
use App\Http\Requests\LoanRequest;
use App\Http\Resources\LoanResource;
use Illuminate\Http\JsonResponse;

class LoanController extends Controller
{
    public function __construct(protected LoanRepositoryInterface $loanRepository)
    {}

    public function index(): JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $loans = $this->loanRepository->getAll();

        if ($loans->isEmpty()) {
            return response()->json([
                'message' => 'No se encontraron prestamos.',
                'error' => true,
                'status' => 404
            ], 404);
        }

        return LoanResource::collection($loans);
    }

    public function show($id): JsonResponse|LoanResource
    {
        $loan = $this->loanRepository->findById($id);

        if (!$loan) {
            return response()->json([
                'message' => 'Prestamo no encontrado.',
                'error' => true,
                'status' => 404
            ], 404);
        }

        return LoanResource::make($loan);
    }

    public function store(LoanRequest $request): JsonResponse
    {
        $loan = $this->loanRepository->create($request->validated());

        return (new LoanResource($loan))
            ->additional([
                'message' => 'Prestamo creado exitosamente.',
                'error' => false,
                'status' => 201
            ])
            ->response()
            ->setStatusCode(201);
    }

    public function update(LoanRequest $request, $id): JsonResponse
    {
        $loan = $this->loanRepository->findById($id);

        if (!$loan) {
            return response()->json([
                'message' => 'Prestamo no encontrado.',
                'error' => true,
                'status' => 404
            ], 404);
        }

        $updatedLoan = $this->loanRepository->update($id, $request->validated());

        return (new LoanResource($updatedLoan))
            ->additional([
                'message' => 'Prestamo actualizado exitosamente.',
                'error' => false,
                'status' => 200
            ])
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Este método maneja el PATCH definido en tus rutas.
     * Gracias al LoanRequest con 'sometimes', la validación es automática.
     */
    public function updatePartial(LoanRequest $request, $id): JsonResponse
    {
        $loan = $this->loanRepository->findById($id);

        if (!$loan) {
            return response()->json([
                'message' => 'Prestamo no encontrado.',
                'error' => true,
                'status' => 404
            ], 404);
        }

        $updatedLoan = $this->loanRepository->update($id, $request->validated());

        return (new LoanResource($updatedLoan))
            ->additional([
                'message' => 'Prestamo editado exitosamente.',
                'error' => false,
                'status' => 200
            ])
            ->response()
            ->setStatusCode(200);
    }

    public function destroy($id): JsonResponse
    {
        $loan = $this->loanRepository->findById($id);

        if (!$loan) {
            return response()->json([
                'message' => 'Prestamo no encontrado.',
                'error' => true,
                'status' => 404
            ], 404);
        }

        $this->loanRepository->delete($id);

        return response()->json([
            'message' => 'Prestamo eliminado exitosamente.',
            'error' => false,
            'status' => 200
        ], 200);
    }
}