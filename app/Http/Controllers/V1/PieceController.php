<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;

use App\Http\Requests\StorePieceRequest;
use App\Http\Requests\UpdatePieceRequest;
use App\Services\PieceService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class PieceController extends Controller
{
    use ApiResponse;

    public function __construct(private PieceService $pieceService) {}

    public function index(Request $request, $blockId)
    {
        $estado = $request->query('estado');

        $pieces = $this->pieceService->getPiecesByBlockWithFilters($blockId, $estado);
        return $this->successResponse($pieces, 'Piezas del bloque obtenidas exitosamente');
    }

    public function byBlock($blockId)
    {
        $pieces = $this->pieceService->getPiecesByBlock($blockId);
        return $this->successResponse($pieces, 'Piezas por bloque obtenidas exitosamente');
    }

    public function store(StorePieceRequest $request, $blockId)
    {
        $piece = $this->pieceService->createPiece($blockId, $request->validated());
        return $this->successResponse($piece, 'Pieza creada correctamente', 201);
    }

    public function show($id)
    {
        $piece = $this->pieceService->getPieceById($id);
        return $this->successResponse($piece, 'Pieza obtenida exitosamente');
    }

    public function update(UpdatePieceRequest $request, $id)
    {
        $piece = $this->pieceService->updatePiece($id, $request->validated());
        return $this->successResponse($piece, 'Pieza actualizada correctamente');
    }

    public function destroy($id)
    {
        $this->pieceService->deletePiece($id);
        return $this->successResponse(null, 'Pieza eliminada correctamente');
    }

    public function report()
    {
        $reportData = $this->pieceService->getReportData();
        return $this->successResponse($reportData, 'Reporte generado exitosamente');
    }
}
