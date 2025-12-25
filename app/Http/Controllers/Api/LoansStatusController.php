<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\LoansStatus;
use App\Repositories\Contracts\LoansStatusRepositoryInterface;
use App\Http\Requests\LoansStatusRequest;
use App\Http\Resources\LoansStatusResource;

class LoansStatusController extends Controller
{
    public function __construct(protected LoansStatusRepositoryInterface $loansStatusRepository)
    {
        $this->loansStatusRepository = $loansStatusRepository;
    }

    public function index()
    {
        $loans_status = $this->loansStatusRepository->getAll();

        if ($loans_status->isEmpty()) {
            $data = [
                'message' => 'No se encontraron estados de prestamos.',
                'error' => true,
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        return LoansStatusResource::collection($loans_status);
    }

    public function show($id)
    {
        $loan_status = $this->loansStatusRepository->findById($id);

        if (!$loan_status) {
            $data = [
                'message' => 'Estado de prestamo no encontrado.',
                'error' => true,
                'status' => 404
            ];

            return response()->json($data, 404);
        }

        return LoansStatusResource::make($loan_status);
    }

    public function store(LoansStatusRequest $request)
    {
        $loan_status = $this->loansStatusRepository->create($request->validated());

        if (!$loan_status) {
            $data = [
                'message' => 'Error al crear el estado de prestamo.',
                'error' => true,
                'status' => 500
            ];

            return response()->json($data, 500);
        }

        return (new LoansStatusResource($loan_status))
            ->additional([
                'message' => 'Estado de prestamo creado exitosamente.',
                'error' => false,
                'status' => 201
            ])
            ->response()
            ->setStatusCode(201);
    }

    public function destroy($id)
    {

    }

    public function update(Request $request, $id)
    {

    }
}
