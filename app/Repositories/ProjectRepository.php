<?php

namespace App\Repositories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

class ProjectRepository
{
    public function getAll(): Collection
    {
        return Project::all();
    }

    public function findById(int $id): Project
    {
        return Project::findOrFail($id);
    }

    public function create(array $data): Project
    {
        return Project::create($data);
    }

    public function update(int $id, array $data): Project
    {
        $project = $this->findById($id);
        $project->update($data);
        return $project;
    }

    public function delete(int $id): bool
    {
        $project = $this->findById($id);
        return $project->delete();
    }
}
