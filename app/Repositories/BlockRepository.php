<?php

namespace App\Repositories;

use App\Models\Block;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class BlockRepository
{
    public function getByProjectId(int $projectId): Collection
    {
        return Block::where('project_id', $projectId)->get();
    }

    public function getByProjectIdPaginated(int $projectId): LengthAwarePaginator
    {
        return Block::where('project_id', $projectId)->paginate(10); // 10 items por página
    }

    public function findById(int $id): Block
    {
        return Block::findOrFail($id);
    }

    public function create(array $data): Block
    {
        return Block::create($data);
    }

    public function update(int $id, array $data): Block
    {
        $block = $this->findById($id);
        $block->update($data);
        return $block;
    }

    public function delete(int $id): bool
    {
        $block = $this->findById($id);
        return $block->delete();
    }
}
