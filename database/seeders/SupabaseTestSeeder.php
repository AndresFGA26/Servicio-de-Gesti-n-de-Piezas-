<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class SupabaseTestSeeder extends Seeder
{
    public function run(): void
    {
        Log::info('=== SUPABASE TEST SEEDER - VERIFICACIÓN COMPLETA ===');
        
        try {
            // 1. Verificar conexión a PostgreSQL
            $pdo = DB::connection()->getPdo();
            $driver = DB::connection()->getDriverName();
            $database = DB::connection()->getDatabaseName();
            
            Log::info('Database connection verified', [
                'driver' => $driver,
                'database' => $database,
                'connection_class' => get_class($pdo)
            ]);
            
            if ($driver !== 'pgsql') {
                throw new \Exception("Expected pgsql driver, got: {$driver}");
            }
            
            // 2. Verificar que todas las tablas existen
            $requiredTables = ['projects', 'blocks', 'pieces'];
            $existingTables = [];
            $missingTables = [];
            
            foreach ($requiredTables as $table) {
                if (Schema::hasTable($table)) {
                    $existingTables[] = $table;
                    
                    // Verificar estructura básica
                    $columns = Schema::getColumnListing($table);
                    Log::info("Table '{$table}' exists", [
                        'columns' => $columns,
                        'column_count' => count($columns)
                    ]);
                } else {
                    $missingTables[] = $table;
                }
            }
            
            if (!empty($missingTables)) {
                throw new \Exception("Missing tables: " . implode(', ', $missingTables));
            }
            
            // 3. Verificar relaciones (foreign keys)
            $relations = [
                'blocks.project_id' => 'projects.id',
                'pieces.block_id' => 'blocks.id'
            ];
            
            foreach ($relations as $fk => $pk) {
                [$table, $column] = explode('.', $fk);
                [$refTable, $refColumn] = explode('.', $pk);
                
                $hasForeignKey = $this->hasForeignKey($table, $column, $refTable);
                Log::info("Foreign key check", [
                    'table' => $table,
                    'column' => $column,
                    'references' => $pk,
                    'exists' => $hasForeignKey
                ]);
                
                if (!$hasForeignKey) {
                    Log::warning("Foreign key missing: {$table}.{$column} -> {$pk}");
                }
            }
            
            // 4. Verificar datos existentes
            $projectsCount = DB::table('projects')->count();
            $blocksCount = DB::table('blocks')->count();
            $piecesCount = DB::table('pieces')->count();
            
            Log::info('Data verification', [
                'projects_count' => $projectsCount,
                'blocks_count' => $blocksCount,
                'pieces_count' => $piecesCount
            ]);
            
            // 5. Verificar consultas complejas
            $complexQuery = DB::select('
                SELECT 
                    p.name as project_name,
                    COUNT(b.id) as blocks_count,
                    COUNT(pc.id) as pieces_count
                FROM projects p
                LEFT JOIN blocks b ON p.id = b.project_id
                LEFT JOIN pieces pc ON b.id = pc.block_id
                GROUP BY p.id, p.name
                ORDER BY p.name
            ');
            
            Log::info('Complex query results', [
                'query_results' => $complexQuery,
                'results_count' => count($complexQuery)
            ]);
            
            // 6. Verificar índices en pieces
            $piecesIndexes = $this->getTableIndexes('pieces');
            Log::info('Pieces table indexes', [
                'indexes' => $piecesIndexes
            ]);
            
            Log::info('=== SUPABASE TEST SEEDER - VERIFICACIÓN EXITOSA ===');
            
            echo "\n✅ Supabase Verification Completed Successfully\n";
            echo "📊 Database: {$database} ({$driver})\n";
            echo "📋 Tables: " . implode(', ', $existingTables) . "\n";
            echo "📈 Data: {$projectsCount} projects, {$blocksCount} blocks, {$piecesCount} pieces\n";
            echo "🔍 Check storage/logs/laravel.log for detailed info\n";
            
        } catch (\Exception $e) {
            Log::error('SupabaseTestSeeder FAILED', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            echo "\n❌ Supabase Verification FAILED\n";
            echo "📋 Error: " . $e->getMessage() . "\n";
            echo "🔍 Check storage/logs/laravel.log for details\n";
            
            throw $e;
        }
    }
    
    private function hasForeignKey(string $table, string $column, string $references): bool
    {
        try {
            $sql = "
                SELECT COUNT(*) as count
                FROM information_schema.table_constraints tc
                JOIN information_schema.key_column_usage kcu 
                    ON tc.constraint_name = kcu.constraint_name
                JOIN information_schema.constraint_column_usage ccu 
                    ON ccu.constraint_name = tc.constraint_name
                WHERE tc.constraint_type = 'FOREIGN KEY' 
                AND tc.table_name = ?
                AND kcu.column_name = ?
                AND ccu.table_name = ?
            ";
            
            $result = DB::select($sql, [$table, $column, explode('.', $references)[0]]);
            return $result[0]->count > 0;
            
        } catch (\Exception $e) {
            Log::warning('Foreign key check failed', [
                'table' => $table,
                'column' => $column,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
    
    private function getTableIndexes(string $table): array
    {
        try {
            $indexes = DB::select("
                SELECT indexname, indexdef 
                FROM pg_indexes 
                WHERE tablename = ? 
                AND schemaname = 'public'
            ", [$table]);
            
            return array_map(function($index) {
                return [
                    'name' => $index->indexname,
                    'definition' => $index->indexdef
                ];
            }, $indexes);
            
        } catch (\Exception $e) {
            Log::warning('Index check failed', [
                'table' => $table,
                'error' => $e->getMessage()
            ]);
            return [];
        }
    }
}
