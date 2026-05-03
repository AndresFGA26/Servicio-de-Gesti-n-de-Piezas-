<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;

use App\Http\Requests\StoreBlockRequest;
use App\Http\Requests\UpdateBlockRequest;
use App\Services\BlockService;
use App\Traits\ApiResponse;

class BlockController extends Controller
{
    use ApiResponse;

    public function __construct(private BlockService $blockService) {}

    public function index($projectId)
    {
        return $this->successResponse($this->blockService->getBlocksByProject($projectId), 'Bloques obtenidos exitosamente');
    }

    public function store(StoreBlockRequest $request)
    {
        $block = $this->blockService->createBlock($request->validated());
        return $this->successResponse($block, 'Bloque creado exitosamente', 201);
    }

    public function show($id)
    {
        $block = $this->blockService->getBlockById($id);
        return $this->successResponse($block, 'Bloque obtenido exitosamente');
    }

    public function update(UpdateBlockRequest $request, $id)
    {
        $block = $this->blockService->updateBlock($id, $request->validated());
        return $this->successResponse($block, 'Bloque actualizado exitosamente');
    }

    public function destroy($id)
    {
        $this->blockService->deleteBlock($id);
        return $this->successResponse(null, 'Bloque eliminado exitosamente');
    }
}
