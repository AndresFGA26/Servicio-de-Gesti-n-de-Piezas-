<?php

namespace App\Services;

use App\Repositories\BlockRepository;
use App\Models\Block;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class BlockService
{
    public function __construct(private BlockRepository $blockRepository) {}

    public function getBlocksByProject(int $projectId): LengthAwarePaginator
    {
        return $this->blockRepository->getByProjectIdPaginated($projectId);
    }

    public function getBlockById(int $id): Block
    {
        return $this->blockRepository->findById($id);
    }

    public function createBlock(array $data): Block
    {
        return $this->blockRepository->create($data);
    }

    public function updateBlock(int $id, array $data): Block
    {
        return $this->blockRepository->update($id, $data);
    }

    public function deleteBlock(int $id): bool
    {
        return $this->blockRepository->delete($id);
    }
}
