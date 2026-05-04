<?php

namespace App\Repositories;

use App\Models\Piece;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class PieceRepository
{
    public function getFilteredPaginated(?int $projectId, ?string $estado, int $perPage = 15): LengthAwarePaginator
    {
        $query = Piece::with('block.project');

        if ($projectId) {
            $query->whereHas('block.project', function ($q) use ($projectId) {
                $q->where('id', $projectId);
            });
        }

        if ($estado) {
            $query->where('estado', $estado);
        }

        return $query->paginate($perPage);
    }

    public function getByBlockIdWithFilters(int $blockId, ?string $estado = null): Collection
    {
        $query = Piece::where('block_id', $blockId);
        
        if ($estado) {
            $query->where('estado', $estado);
        }
        
        return $query->get();
    }

    public function getByBlockIdWithFiltersPaginated(int $blockId, ?string $estado = null): LengthAwarePaginator
    {
        $query = Piece::where('block_id', $blockId);

        if ($estado) {
            $query->where('estado', $estado);
        }

        return $query->paginate(10); // 10 items por página
    }

    public function getByBlockId(int $blockId): Collection
    {
        return Piece::where('block_id', $blockId)->get();
    }

    public function findById(int $id): Piece
    {
        return Piece::findOrFail($id);
    }

    public function create(array $data): Piece
    {
        return Piece::create($data);
    }

    public function update(int $id, array $data): Piece
    {
        $piece = $this->findById($id);
        $piece->update($data);
        return $piece;
    }

    public function delete(int $id): bool
    {
        $piece = $this->findById($id);
        return $piece->delete();
    }

    public function getReportData(): array
    {
        // 1. Totales globales eficientes (Query Builder es más rápido para simples agregaciones)
        $totals = DB::table('pieces')
            ->select('estado', DB::raw('COUNT(*) as total'))
            ->groupBy('estado')
            ->pluck('total', 'estado'); // Retorna un array plano ['Fabricada' => 10, 'Pendiente' => 5]

        // 2. Eloquent Avanzado (withCount y hasManyThrough) para agrupar por proyectos
        $projects = \App\Models\Project::withCount([
            'pieces as fabricadas_count' => fn($query) => $query->where('estado', 'Fabricada'),
            'pieces as pendientes_count' => fn($query) => $query->where('estado', 'Pendiente'),
        ])->get();

        // 3. Estructuración limpia y profesional para el Frontend
        $structuredProjects = $projects->map(function ($project) {
            return [
                'id' => $project->id,
                'name' => $project->name,
                'stats' => [
                    'Fabricada' => $project->fabricadas_count,
                    'Pendiente' => $project->pendientes_count,
                    'Total' => $project->fabricadas_count + $project->pendientes_count,
                ]
            ];
        });

        return [
            'totals' => $totals,
            'projects' => $structuredProjects,
        ];
    }
}
