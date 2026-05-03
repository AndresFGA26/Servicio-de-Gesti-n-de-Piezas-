<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Block;
use App\Models\Project;
use Illuminate\Support\Facades\Log;

class BlocksSeeder extends Seeder
{
    public function run(): void
    {
        Log::info('=== BLOCKS SEEDER STARTED ===');
        
        try {
            // Obtener proyectos existentes
            $projects = Project::all();
            
            if ($projects->isEmpty()) {
                Log::warning('No projects found - running ProjectsSeeder first');
                $this->call(ProjectsSeeder::class);
                $projects = Project::all();
            }
            
            // Crear bloques de ejemplo para cada proyecto
            $blocksData = [
                'Proyecto Estructura Metálica A' => [
                    ['name' => 'Bloque Fundaciones'],
                    ['name' => 'Bloque Columnas Principales'],
                    ['name' => 'Bloque Vigas Maestras'],
                ],
                'Proyecto Edificio Corporativo B' => [
                    ['name' => 'Bloque Losa Primer Nivel'],
                    ['name' => 'Bloque Escaleras'],
                    ['name' => 'Bloque Muros Perimetrales'],
                ],
                'Proyecto Puente Peatonal C' => [
                    ['name' => 'Bloque Vigas Principales'],
                    ['name' => 'Bloque Tablero'],
                    ['name' => 'Bloque Barandillas'],
                ],
            ];
            
            $totalBlocksCreated = 0;
            
            foreach ($blocksData as $projectName => $blocks) {
                $project = Project::where('name', $projectName)->first();
                
                if (!$project) {
                    Log::warning("Project '{$projectName}' not found, skipping blocks");
                    continue;
                }
                
                foreach ($blocks as $blockData) {
                    $block = Block::firstOrCreate(
                        [
                            'project_id' => $project->id,
                            'name' => $blockData['name']
                        ],
                        $blockData
                    );
                    
                    Log::info('Block created/found', [
                        'id' => $block->id,
                        'project_id' => $block->project_id,
                        'name' => $block->name,
                        'project_name' => $projectName
                    ]);
                    
                    $totalBlocksCreated++;
                }
            }
            
            $totalBlocks = Block::count();
            Log::info('Blocks seeder completed', [
                'total_blocks' => $totalBlocks,
                'blocks_created_this_run' => $totalBlocksCreated
            ]);
            
            echo "✅ Blocks Seeder: {$totalBlocks} blocks created\n";
            
        } catch (\Exception $e) {
            Log::error('Blocks seeder failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            echo "❌ Blocks Seeder FAILED: " . $e->getMessage() . "\n";
            throw $e;
        }
        
        Log::info('=== BLOCKS SEEDER COMPLETED ===');
    }
}
