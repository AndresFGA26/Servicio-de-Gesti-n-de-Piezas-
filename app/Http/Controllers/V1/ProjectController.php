<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Services\ProjectService;
use App\Traits\ApiResponse;

class ProjectController extends Controller
{
    use ApiResponse;

    public function __construct(private ProjectService $projectService) {}

    public function index()
    {
        $projects = $this->projectService->getAllProjects();
        return $this->successResponse($projects, 'Proyectos obtenidos exitosamente');
    }

    public function store(StoreProjectRequest $request)
    {
        $project = $this->projectService->createProject($request->validated());
        return $this->successResponse($project, 'Proyecto creado exitosamente', 201);
    }

    public function show($id)
    {
        $project = $this->projectService->getProjectById($id);
        return $this->successResponse($project, 'Proyecto obtenido exitosamente');
    }

    public function update(UpdateProjectRequest $request, $id)
    {
        $project = $this->projectService->updateProject($id, $request->validated());
        return $this->successResponse($project, 'Proyecto actualizado exitosamente');
    }

    public function destroy($id)
    {
        $this->projectService->deleteProject($id);
        return $this->successResponse(null, 'Proyecto eliminado exitosamente');
    }
}
