<?php

namespace App\Services;

use App\Repositories\PieceRepository;
use App\Models\Piece;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class PieceService
{
    public function __construct(private PieceRepository $pieceRepository) {}

    public function getFilteredPaginated(?int $projectId, ?string $estado): LengthAwarePaginator
    {
        return $this->pieceRepository->getFilteredPaginated($projectId, $estado);
    }

    public function getPiecesByBlockWithFilters(int $blockId, ?string $estado = null): LengthAwarePaginator
    {
        return $this->pieceRepository->getByBlockIdWithFiltersPaginated($blockId, $estado);
    }

    public function getPiecesByBlock(int $blockId): Collection
    {
        return $this->pieceRepository->getByBlockId($blockId);
    }

    public function createPiece(int $blockId, array $data): Piece
    {
        $pesoReal = $data['peso_real'] ?? null;
        $pesoTeorico = $data['peso_teorico'];
        
        // Calcular diferencia solo si hay peso real
        $diferencia = $pesoReal !== null ? $pesoReal - $pesoTeorico : null;
        
        // Determinar estado: Fabricada solo si tiene peso real, sino Pendiente
        $estado = $pesoReal !== null && $pesoReal > 0 ? 'Fabricada' : 'Pendiente';

        $pieceData = [
            'block_id' => $blockId,
            'peso_teorico' => $pesoTeorico,
            'peso_real' => $pesoReal,
            'diferencia_peso' => $diferencia,
            'estado' => $estado,
            'fecha_fabricacion' => $estado === 'Fabricada' ? now() : null,
        ];

        return $this->pieceRepository->create($pieceData);
    }

    public function getPieceById(int $id): Piece
    {
        return $this->pieceRepository->findById($id);
    }

    public function updatePiece(int $id, array $data): Piece
    {
        $pesoReal = $data['peso_real'] ?? null;
        $pesoTeorico = $data['peso_teorico'];
        
        // Calcular diferencia solo si hay peso real
        $diferencia = $pesoReal !== null ? $pesoReal - $pesoTeorico : null;
        
        // Determinar estado: Fabricada solo si tiene peso real, sino Pendiente
        $estado = $pesoReal !== null && $pesoReal > 0 ? 'Fabricada' : 'Pendiente';

        $pieceData = [
            'peso_teorico' => $pesoTeorico,
            'peso_real' => $pesoReal,
            'diferencia_peso' => $diferencia,
            'estado' => $estado,
            'fecha_fabricacion' => $estado === 'Fabricada' ? now() : null,
        ];

        return $this->pieceRepository->update($id, $pieceData);
    }

    public function deletePiece(int $id): bool
    {
        return $this->pieceRepository->delete($id);
    }

    public function getReportData(): array
    {
        return $this->pieceRepository->getReportData();
    }
}
