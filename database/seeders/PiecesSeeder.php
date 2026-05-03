<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Piece;
use App\Models\Block;
use Illuminate\Support\Facades\Log;

class PiecesSeeder extends Seeder
{
    public function run(): void
    {
        Log::info('=== PIECES SEEDER STARTED ===');
        
        try {
            // Obtener bloques existentes
            $blocks = Block::all();
            
            if ($blocks->isEmpty()) {
                Log::warning('No blocks found - running BlocksSeeder first');
                $this->call(BlocksSeeder::class);
                $blocks = Block::all();
            }
            
            // Crear piezas de ejemplo para cada bloque
            $piecesData = [
                // Bloque Fundaciones
                'Bloque Fundaciones' => [
                    ['peso_teorico' => 25.50, 'peso_real' => 26.20, 'estado' => 'Fabricada'],
                    ['peso_teorico' => 18.75, 'peso_real' => null, 'estado' => 'Pendiente'],
                    ['peso_teorico' => 32.10, 'peso_real' => 31.85, 'estado' => 'Fabricada'],
                ],
                // Bloque Columnas Principales
                'Bloque Columnas Principales' => [
                    ['peso_teorico' => 45.30, 'peso_real' => 44.90, 'estado' => 'Fabricada'],
                    ['peso_teorico' => 38.20, 'peso_real' => null, 'estado' => 'Pendiente'],
                    ['peso_teorico' => 52.15, 'peso_real' => 53.10, 'estado' => 'Fabricada'],
                ],
                // Bloque Vigas Maestras
                'Bloque Vigas Maestras' => [
                    ['peso_teorico' => 78.90, 'peso_real' => 79.25, 'estado' => 'Fabricada'],
                    ['peso_teorico' => 65.40, 'peso_real' => null, 'estado' => 'Pendiente'],
                ],
                // Losa Primer Nivel
                'Bloque Losa Primer Nivel' => [
                    ['peso_teorico' => 12.30, 'peso_real' => 12.45, 'estado' => 'Fabricada'],
                    ['peso_teorico' => 15.60, 'peso_real' => 15.20, 'estado' => 'Fabricada'],
                    ['peso_teorico' => 14.80, 'peso_real' => null, 'estado' => 'Pendiente'],
                ],
                // Escaleras
                'Bloque Escaleras' => [
                    ['peso_teorico' => 22.10, 'peso_real' => 22.30, 'estado' => 'Fabricada'],
                    ['peso_teorico' => 19.50, 'peso_real' => null, 'estado' => 'Pendiente'],
                ],
                // Vigas Principales (Puente)
                'Bloque Vigas Principales' => [
                    ['peso_teorico' => 125.75, 'peso_real' => 126.20, 'estado' => 'Fabricada'],
                    ['peso_teorico' => 118.30, 'peso_real' => null, 'estado' => 'Pendiente'],
                ],
            ];
            
            $totalPiecesCreated = 0;
            
            foreach ($piecesData as $blockName => $pieces) {
                $block = Block::where('name', $blockName)->first();
                
                if (!$block) {
                    Log::warning("Block '{$blockName}' not found, skipping pieces");
                    continue;
                }
                
                foreach ($pieces as $pieceData) {
                    // Calcular diferencia_peso si hay peso_real
                    if ($pieceData['peso_real'] !== null) {
                        $pieceData['diferencia_peso'] = $pieceData['peso_real'] - $pieceData['peso_teorico'];
                        $pieceData['fecha_fabricacion'] = now();
                    } else {
                        $pieceData['diferencia_peso'] = null;
                        $pieceData['fecha_fabricacion'] = null;
                    }
                    
                    $piece = Piece::firstOrCreate(
                        [
                            'block_id' => $block->id,
                            'peso_teorico' => $pieceData['peso_teorico']
                        ],
                        $pieceData
                    );
                    
                    Log::info('Piece created/found', [
                        'id' => $piece->id,
                        'block_id' => $piece->block_id,
                        'block_name' => $blockName,
                        'peso_teorico' => $piece->peso_teorico,
                        'peso_real' => $piece->peso_real,
                        'estado' => $piece->estado
                    ]);
                    
                    $totalPiecesCreated++;
                }
            }
            
            $totalPieces = Piece::count();
            Log::info('Pieces seeder completed', [
                'total_pieces' => $totalPieces,
                'pieces_created_this_run' => $totalPiecesCreated
            ]);
            
            echo "✅ Pieces Seeder: {$totalPieces} pieces created\n";
            
        } catch (\Exception $e) {
            Log::error('Pieces seeder failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            echo "❌ Pieces Seeder FAILED: " . $e->getMessage() . "\n";
            throw $e;
        }
        
        Log::info('=== PIECES SEEDER COMPLETED ===');
    }
}
