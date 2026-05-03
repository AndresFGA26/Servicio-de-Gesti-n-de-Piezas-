<?php

namespace App\Services;

use App\Repositories\ProjectRepository;
use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

class ProjectService
{
    public function __construct(private ProjectRepository $projectRepository) {}

    public function getAllProjects(): Collection
    {
        return $this->projectRepository->getAll();
    }

    public function getProjectById(int $id): Project
    {
        return $this->projectRepository->findById($id);
    }

    public function createProject(array $data): Project
    {
        return $this->projectRepository->create($data);
    }

    public function updateProject(int $id, array $data): Project
    {
        return $this->projectRepository->update($id, $data);
    }

    public function deleteProject(int $id): bool
    {
        return $this->projectRepository->delete($id);
    }
}
