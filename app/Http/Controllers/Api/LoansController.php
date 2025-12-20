<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Loans;
use App\Repositories\Contracts\LoansRepositoryInterface;
use App\Http\Requests\LoansRequest;
use App\Http\Resources\LoansResource;

class LoansController extends Controller
{
    public function __construct(protected LoansRepositoryInterface $loansRepository)
    {
        $this->loansRepository = $loansRepository;
    }

    public function index()
    {
        $loans = $this->loansRepository->getAll();

        if ($loans->isEmpty()) {
            $data = [
                'message' => 'No se encontraron prestamos.',
                'error' => true,
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        return LoansResource::collection($loans);
    }

    public function show($id)
    {
        $loan = $this->loansRepository->findById($id);

        if (!$loan) {
            $data = [
                'message' => 'Prestamo no encontrado.',
                'error' => true,
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        return LoansResource::make($loan);
    }

    public function store(LoansRequest $request)
    {
        $loan = $this->loansRepository->create($request->validated());

        if (!$loan) {
            $data = [
                'message' => 'Error al crear el prestamo.',
                'error' => true,
                'status' => 500
            ];

            return response()->json($data, 500);
        }

        return (new LoansResource($loan))
            ->additional([
                'message' => 'Prestamo creado exitosamente.',
                'error' => false,
                'status' => 201
            ])
            ->response()
            ->setStatusCode(201);
    }

    public function destroy($id)
    {
        $loan = $this->loansRepository->findById($id);

        if (!$loan) {
            $data = [
                'message' => 'Prestamo no encontrado.',
                'error' => true,
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        $this->loansRepository->delete($id);

        $data = [
            'message' => 'Prestamo eliminado exitosamente.',
            'error' => false,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function update(LoansRequest $request, $id)
    {
        $loan = $this->loansRepository->findById($id);

        if (!$loan) {
            $data = [
                'message' => 'Prestamo no encontrado.',
                'error' => true,
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        $updatedLoan = $this->loansRepository->update($id, $request->validated());

        return (new LoansResource($updatedLoan))
            ->additional([
                'message' => 'Prestamo actualizado exitosamente.',
                'error' => false,
                'status' => 200
            ])
            ->response()
            ->setStatusCode(200);
    }
}
