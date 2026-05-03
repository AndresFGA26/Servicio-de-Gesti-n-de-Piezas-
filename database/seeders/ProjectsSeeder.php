<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;
use Illuminate\Support\Facades\Log;

class ProjectsSeeder extends Seeder
{
    public function run(): void
    {
        Log::info('=== PROJECTS SEEDER STARTED ===');
        
        try {
            // Crear proyectos de ejemplo
            $projects = [
                [
                    'name' => 'Proyecto Estructura Metálica A',
                ],
                [
                    'name' => 'Proyecto Edificio Corporativo B',
                ],
                [
                    'name' => 'Proyecto Puente Peatonal C',
                ],
            ];
            
            foreach ($projects as $projectData) {
                $project = Project::firstOrCreate(
                    ['name' => $projectData['name']],
                    $projectData
                );
                
                Log::info('Project created/found', [
                    'id' => $project->id,
                    'name' => $project->name,
                    'created_at' => $project->created_at
                ]);
            }
            
            $totalProjects = Project::count();
            Log::info('Projects seeder completed', [
                'total_projects' => $totalProjects
            ]);
            
            echo "✅ Projects Seeder: {$totalProjects} projects created\n";
            
        } catch (\Exception $e) {
            Log::error('Projects seeder failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            echo "❌ Projects Seeder FAILED: " . $e->getMessage() . "\n";
            throw $e;
        }
        
        Log::info('=== PROJECTS SEEDER COMPLETED ===');
    }
}
