<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Block;
use App\Models\Piece;

class ProjectBlockPieceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Crear Proyectos
        $project1 = Project::firstOrCreate(['name' => 'Torre Norte']);
        $project2 = Project::firstOrCreate(['name' => 'Puente Sur']);

        // 2. Crear Bloques para Torre Norte
        $blockA = Block::firstOrCreate([
            'project_id' => $project1->id,
            'name' => 'Estructura Base'
        ]);
        
        $blockB = Block::firstOrCreate([
            'project_id' => $project1->id,
            'name' => 'Niveles Superiores'
        ]);

        // Crear Bloque para Puente Sur
        $blockC = Block::firstOrCreate([
            'project_id' => $project2->id,
            'name' => 'Pilares Principales'
        ]);

        // 3. Crear Piezas (Fabricadas y Pendientes)
        
        // Bloque A: 2 fabricadas, 1 pendiente
        Piece::firstOrCreate([
            'block_id' => $blockA->id,
            'peso_teorico' => 150.50,
            'peso_real' => 151.00,
            'diferencia_peso' => 0.50,
            'estado' => 'Fabricada',
            'fecha_fabricacion' => now()->subDays(2)
        ]);
        Piece::firstOrCreate([
            'block_id' => $blockA->id,
            'peso_teorico' => 120.00,
            'peso_real' => 119.80,
            'diferencia_peso' => -0.20,
            'estado' => 'Fabricada',
            'fecha_fabricacion' => now()->subDay()
        ]);
        Piece::firstOrCreate([
            'block_id' => $blockA->id,
            'peso_teorico' => 300.00,
            'peso_real' => null,
            'diferencia_peso' => null,
            'estado' => 'Pendiente',
            'fecha_fabricacion' => null
        ]);

        // Bloque B: Todas pendientes
        Piece::firstOrCreate([
            'block_id' => $blockB->id,
            'peso_teorico' => 50.00,
            'peso_real' => null,
            'diferencia_peso' => null,
            'estado' => 'Pendiente',
            'fecha_fabricacion' => null
        ]);
        Piece::firstOrCreate([
            'block_id' => $blockB->id,
            'peso_teorico' => 50.00,
            'peso_real' => null,
            'diferencia_peso' => null,
            'estado' => 'Pendiente',
            'fecha_fabricacion' => null
        ]);

        // Bloque C: Todas fabricadas
        Piece::firstOrCreate([
            'block_id' => $blockC->id,
            'peso_teorico' => 1000.00,
            'peso_real' => 1005.00,
            'diferencia_peso' => 5.00,
            'estado' => 'Fabricada',
            'fecha_fabricacion' => now()->subWeeks(1)
        ]);
    }
}
