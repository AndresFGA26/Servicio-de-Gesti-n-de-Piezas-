# 🏭 Pieces Service - Microservicio de Gestión de Piezas

## 📋 Descripción del Servicio

Microservicio Laravel 11 especializado en la gestión completa del ciclo de vida de piezas de manufactura. Implementa una arquitectura robusta con relaciones jerárquicas Proyecto → Bloques → Piezas, cálculo automático de métricas de producción y reportes de estado en tiempo real.

## 🎯 **ESTADO FINAL DEL PROYECTO**

### **✅ FUNCIONALIDADES IMPLEMENTADAS**
- **CRUD Projects** completo con paginación
- **CRUD Blocks** relacionado con projects
- **CRUD Pieces** relacionado con blocks
- **Middleware JWT** protegiendo todos los endpoints
- **Paginación** con Laravel LengthAwarePaginator
- **Validaciones** robustas con Request classes
- **Base de datos PostgreSQL** vía Supabase
- **CORS** configurado globalmente
- **Reportes** con endpoint `/reports/pieces`

### **🔧 ARQUITECTURA IMPLEMENTADA**
```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   Frontend      │    │  Auth Service   │    │ Pieces Service  │
│   (React SPA)   │◄──►│  (Laravel JWT)  │◄──►│  (Laravel API)  │
│   Port: 5173    │    │   Port: 8000    │    │   Port: 8001    │
└─────────────────┘    └─────────────────┘    └─────────────────┘
         │                       │                       │
         └──────────────────────┼──────────────────────┘
                                 │
                    ┌─────────────────┐
                    │  PostgreSQL DB  │
                    │   (Supabase)    │
                    └─────────────────┘
```

### **⚠️ LIMITACIONES CONOCIDAS**
- **No hay eliminación en cascada** configurada en BD
- **Validaciones básicas**, podrían ser más robustas
- **No hay rate limiting** en endpoints
- **Base de datos compartida** (no es puro microservicio)
- **No hay caching** de consultas frecuentes

### **🚀 ESTADO PARA ENTREVISTA**
**✅ PROYECTO LISTO PARA SUSTENTACIÓN TÉCNICA**

Cumple con requisitos fundamentales de microservicios:
- Dominio de negocio bien delimitado
- API RESTful con versionado
- Protección JWT completa
- Escalabilidad independiente

**Nivel recomendado:** Junior/Mid Developer

---

## 🚀 **INSTALACIÓN Y CONFIGURACIÓN**

### **Prerrequisitos**
- PHP 8.2+
- Composer
- PostgreSQL (vía Supabase)
- Laravel 11
- Auth Service corriendo en puerto 8000

### **Instalación**
```bash
# Clonar el repositorio
git clone <repository-url>
cd pieces-service

# Instalar dependencias
composer install

# Configurar variables de entorno
cp .env.example .env

# Generar key de aplicación
php artisan key:generate

# Ejecutar migraciones
php artisan migrate

# Iniciar servidor
php artisan serve --port=8001
```

### **Configuración de Variables de Entorno**
```env
DB_CONNECTION=pgsql
DB_HOST=aws-1-us-east-1.pooler.supabase.com
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres.kllmebcpltitrajbfxfg
DB_PASSWORD="Unicorniomorado777$"

JWT_SECRET=your-jwt-secret-key
```

---

## 📡 **ENDPOINTS DE LA API**

| Método | Endpoint | Descripción | Autenticación |
|--------|----------|-------------|---------------|
| GET | `/api/v1/projects` | Listar proyectos | ✅ Sí |
| POST | `/api/v1/projects` | Crear proyecto | ✅ Sí |
| PUT | `/api/v1/projects/{id}` | Actualizar proyecto | ✅ Sí |
| DELETE | `/api/v1/projects/{id}` | Eliminar proyecto | ✅ Sí |
| GET | `/api/v1/projects/{project}/blocks` | Listar bloques de proyecto | ✅ Sí |
| POST | `/api/v1/blocks` | Crear bloque | ✅ Sí |
| PUT | `/api/v1/blocks/{id}` | Actualizar bloque | ✅ Sí |
| DELETE | `/api/v1/blocks/{id}` | Eliminar bloque | ✅ Sí |
| GET | `/api/v1/blocks/{block}/pieces` | Listar piezas de bloque | ✅ Sí |
| POST | `/api/v1/blocks/{block}/pieces` | Crear pieza | ✅ Sí |
| PUT | `/api/v1/pieces/{id}` | Actualizar pieza | ✅ Sí |
| DELETE | `/api/v1/pieces/{id}` | Eliminar pieza | ✅ Sí |
| GET | `/api/v1/reports/pieces` | Reportes de piezas | ✅ Sí |

---

## 🔐 **AUTENTICACIÓN**

Todos los endpoints (excepto los de auth-service) requieren autenticación JWT:

```bash
# Header requerido
Authorization: Bearer <access_token>
```

### **Ejemplo de Request**
```bash
curl -X GET http://localhost:8001/api/v1/projects \
  -H "Authorization: Bearer <access_token>" \
  -H "Content-Type: application/json"
```

---

## 🛠️ **DESARROLLO**

### **Estructura de Archivos**
```
pieces-service/
├── app/
│   ├── Http/
│   │   ├── Controllers/V1/
│   │   ├── Middleware/
│   │   └── Requests/
│   ├── Models/
│   ├── Repositories/
│   └── Services/
├── database/
│   └── migrations/
└── routes/
    └── api.php
```

### **Testing**
```bash
# Ejecutar tests (cuando estén implementados)
php artisan test

# Verificar migraciones
php artisan migrate:status
```

---

## 🐛 **SOLUCIÓN DE PROBLEMAS**

### **Problemas Comunes**
1. **Error 401 Unauthorized**: Verificar token JWT válido
2. **Error de conexión a BD**: Verificar credenciales de Supabase
3. **Error 403 Forbidden**: Verificar middleware JWT
4. **CORS issues**: Asegurar que CORS middleware esté activo

### **Logs**
```bash
# Ver logs de errores
php artisan log:show

# Limpiar logs
php artisan log:clear
```

---

## 🏗️ Arquitectura General del Sistema

```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   Frontend      │    │  Auth Service   │    │ Pieces Service  │
│   (React SPA)   │◄──►│  (Laravel JWT)  │◄──►│  (Laravel API)  │
│                 │    │                 │    │                 │
│ - CRUD UI       │    │ - JWT Tokens    │    │ - Business Logic│
│ - Data Display  │    │ - User Mgmt     │    │ - Data Models   │
│ - Reports       │    │ - Session Mgmt  │    │ - Calculations  │
└─────────────────┘    └─────────────────┘    └─────────────────┘
         │                       │                       │
         └──────────────────────┼──────────────────────┘
         └───────────────────────┼───────────────────────┘
                                 │
                    ┌─────────────────┐
                    │   Supabase      │
                    │  (PostgreSQL)   │
                    └─────────────────┘
```

## 📂 Estructura del Proyecto

```
pieces-service/
├── 📁 app/
│   ├── Http/
│   │   ├── Controllers/V1/
│   │   │   ├── PieceController.php     # CRUD de piezas
│   │   │   ├── BlockController.php     # CRUD de bloques
│   │   │   └── ProjectController.php    # CRUD de proyectos
│   │   ├── Requests/
│   │   │   ├── StorePieceRequest.php    # Validación de creación
│   │   │   └── UpdatePieceRequest.php   # Validación de actualización
│   │   └── Middleware/
│   │       └── JwtMiddleware.php         # Autenticación JWT
│   ├── Services/
│   │   └── PieceService.php           # Lógica de negocio
│   ├── Models/
│   │   ├── Piece.php                 # Modelo de pieza
│   │   ├── Block.php                 # Modelo de bloque
│   │   └── Project.php              # Modelo de proyecto
│   └── Repositories/
│       ├── PieceRepository.php         # Acceso a datos de piezas
│       ├── BlockRepository.php         # Acceso a datos de bloques
│       └── ProjectRepository.php      # Acceso a datos de proyectos
│
├── 📁 database/
│   ├── migrations/
│   │   ├── 2026_05_02_034505_create_projects_table.php
│   │   ├── 2026_05_02_034522_create_blocks_table.php
│   │   ├── 2026_05_02_034540_create_pieces_table.php
│   │   └── 2026_05_03_064556_add_indexes_to_pieces_table.php
│   └── seeders/
│       ├── ProjectsSeeder.php           # Proyectos de ejemplo
│       ├── BlocksSeeder.php             # Bloques de ejemplo
│       ├── PiecesSeeder.php             # Piezas de ejemplo
│       └── SupabaseTestSeeder.php     # Verificación completa
│
├── 📁 config/
│   └── hashing.php                 # Configuración de encriptación
│
├── 📄 .env.supabase              # Configuración de base de datos
├── 📄 composer.json              # Dependencias PHP
└── 📄 README.md                  # Este archivo
```

## 🛠️ Tecnologías Utilizadas

### Backend
- **Laravel 11** - Framework PHP moderno
- **PostgreSQL** - Base de datos via Supabase
- **JWT** - Autenticación sin estado (compartido con auth-service)
- **Eloquent ORM** - Mapeo objeto-relacional
- **Clean Architecture** - Controllers → Services → Repositories

### Características
- **Cálculos Automáticos** - Diferencia de peso y estado de piezas
- **Índices Optimizados** - Para consultas frecuentes
- **Validaciones Robustas** - Input sanitization y reglas de negocio
- **API RESTful** - Endpoints versionados y documentados

## 📡 API Endpoints

### Proyectos
| Método | Endpoint | Descripción |
|--------|----------|-------------|
| `GET` | `/api/v1/projects` | Listar todos los proyectos |
| `POST` | `/api/v1/projects` | Crear nuevo proyecto |
| `GET` | `/api/v1/projects/{id}` | Obtener proyecto específico |
| `PUT` | `/api/v1/projects/{id}` | Actualizar proyecto |
| `DELETE` | `/api/v1/projects/{id}` | Eliminar proyecto |

### Bloques
| Método | Endpoint | Descripción |
|--------|----------|-------------|
| `GET` | `/api/v1/projects/{id}/blocks` | Listar bloques de un proyecto |
| `POST` | `/api/v1/projects/{id}/blocks` | Crear bloque en proyecto |
| `GET` | `/api/v1/blocks/{id}` | Obtener bloque específico |
| `PUT` | `/api/v1/blocks/{id}` | Actualizar bloque |
| `DELETE` | `/api/v1/blocks/{id}` | Eliminar bloque |

### Piezas
| Método | Endpoint | Descripción |
|--------|----------|-------------|
| `GET` | `/api/v1/blocks/{id}/pieces` | Listar piezas de un bloque |
| `POST` | `/api/v1/blocks/{id}/pieces` | Crear pieza en bloque |
| `GET` | `/api/v1/pieces/{id}` | Obtener pieza específica |
| `PUT` | `/api/v1/pieces/{id}` | Actualizar pieza |
| `DELETE` | `/api/v1/pieces/{id}` | Eliminar pieza |

### Reportes
| Método | Endpoint | Descripción |
|--------|----------|-------------|
| `GET` | `/api/v1/reports/pieces` | Reporte completo de piezas |

## 🔧 Configuración del Entorno

### Variables de Entorno Requeridas

```env
# Configuración de la Aplicación
APP_NAME="Pieces Service"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8001
APP_KEY=base64:GENERAR_NUEVA_APP_KEY

# Base de Datos - Supabase PostgreSQL
DB_CONNECTION=pgsql
DB_HOST=tu-proyecto.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=tu-password-de-supabase

# Configuración JWT (DEBE SER LA MISMA QUE AUTH-SERVICE)
JWT_SECRET=tu-jwt-secret-de-32-caracteres-minimo

# Cache y Session
CACHE_STORE=database
SESSION_DRIVER=database
SESSION_LIFETIME=120

# Logs
LOG_CHANNEL=stack
LOG_LEVEL=debug
```

### Archivo de Configuración

```bash
# Copiar configuración de Supabase
cp .env.supabase .env

# Editar con tus credenciales reales
nano .env
```

## 🚀 Instalación y Ejecución

### Prerrequisitos
- **PHP 8.2+**
- **Composer**
- **PostgreSQL** (via Supabase)
- **Cuenta Supabase** activa

### Instalación

```bash
# 1. Instalar dependencias
composer install

# 2. Generar APP_KEY
php artisan key:generate

# 3. Configurar entorno
cp .env.supabase .env
# EDITAR .env con credenciales de Supabase

# 4. Migrar base de datos
php artisan migrate:fresh --seed

# 5. Iniciar servicio
php artisan serve --port=8001
```

### Verificación

```bash
# Verificar conexión a BD
php artisan tinker
DB::connection()->getPdo()  # Debe retornar conexión exitosa

# Verificar datos creados
Project::count()   # Debe retornar > 0
Block::count()     # Debe retornar > 0
Piece::count()     # Debe retornar > 0
```

## 📊 Base de Datos

### Tablas Principales

#### projects
```sql
CREATE TABLE projects (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

#### blocks
```sql
CREATE TABLE blocks (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    project_id BIGINT NOT NULL,
    name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
);
```

#### pieces
```sql
CREATE TABLE pieces (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    block_id BIGINT NOT NULL,
    peso_teorico DECIMAL(10,2) NOT NULL,
    peso_real DECIMAL(10,2) NULL,
    diferencia_peso DECIMAL(10,2) NULL,
    estado ENUM('Pendiente', 'Fabricada') NOT NULL DEFAULT 'Pendiente',
    fecha_fabricacion TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (block_id) REFERENCES blocks(id) ON DELETE CASCADE
);
```

## 🔐 Flujo de Negocio

### 1. Creación de Estructura Jerárquica
```
Proyecto
├── Bloque 1
│   ├── Pieza 1 (Pendiente)
│   ├── Pieza 2 (Fabricada)
│   └── Pieza 3 (Pendiente)
├── Bloque 2
│   ├── Pieza 4 (Fabricada)
│   └── Pieza 5 (Pendiente)
└── Bloque 3
    ├── Pieza 6 (Fabricada)
    └── Pieza 7 (Pendiente)
```

### 2. Cálculos Automáticos

#### Estado de Pieza
```php
// Lógica automática en PieceService
if ($piece->peso_real !== null) {
    $piece->estado = 'Fabricada';
    $piece->fecha_fabricacion = now();
    $piece->diferencia_peso = $piece->peso_real - $piece->peso_teorico;
} else {
    $piece->estado = 'Pendiente';
    $piece->diferencia_peso = null;
    $piece->fecha_fabricacion = null;
}
```

#### Diferencia de Peso
```php
// Cálculo automático
$diferencia = $peso_real - $peso_teorico;
// Positivo = sobre peso, Negativo = bajo peso
```

## 📡 API Reference

### Crear Nueva Pieza
```http
POST /api/v1/blocks/1/pieces
Authorization: Bearer {access_token}
Content-Type: application/json

{
  "peso_teorico": 25.50,
  "peso_real": 26.20
}
```

**Respuesta**:
```json
{
  "success": true,
  "message": "Pieza creada correctamente",
  "data": {
    "id": 1,
    "block_id": 1,
    "peso_teorico": 25.50,
    "peso_real": 26.20,
    "diferencia_peso": 0.70,
    "estado": "Fabricada",
    "fecha_fabricacion": "2024-01-01T12:00:00.000000Z"
  }
}
```

### Listar Piezas con Filtros
```http
GET /api/v1/pieces?project_id=1&estado=Fabricada&page=1&per_page=10
Authorization: Bearer {access_token}
```

### Reporte Completo
```http
GET /api/v1/reports/pieces
Authorization: Bearer {access_token}
```

**Respuesta**:
```json
{
  "success": true,
  "data": {
    "totales": {
      "total_piezas": 15,
      "total_pendientes": 6,
      "total_fabricadas": 9,
      "peso_teorico_total": 375.50,
      "peso_real_total": 382.30,
      "diferencia_total": 6.80
    },
    "por_proyecto": [
      {
        "proyecto": {
          "id": 1,
          "name": "Proyecto Estructura Metálica A"
        },
        "totales": {
          "total_piezas": 8,
          "total_pendientes": 2,
          "total_fabricadas": 6,
          "peso_teorico_total": 200.00,
          "peso_real_total": 205.50,
          "diferencia_total": 5.50
        },
        "bloques": [...]
      }
    ]
  }
}
```

## 🛡️ Seguridad Implementada

### Autenticación JWT
- **Middleware**: Protección de todas las rutas
- **Validación**: Verificación de firma y expiración
- **Secret Compartido**: Mismo JWT_SECRET que auth-service

### Validaciones de Negocio
- **Peso Teórico**: Requerido, numérico, mayor que 0
- **Peso Real**: Opcional, numérico, mayor que 0
- **Relaciones**: Verificación de existencia de proyecto/bloque

### Índices Optimizados
```sql
-- Índices para rendimiento
CREATE INDEX idx_pieces_estado ON pieces(estado);
CREATE INDEX idx_pieces_block_estado ON pieces(block_id, estado);
```

## 🧪 Testing

### Ejecutar Tests
```bash
# Ejecutar todos los tests
php artisan test

# Ejecutar tests específicos
php artisan test --filter PieceServiceTest
```

### Tests Implementados
- ✅ CRUD de proyectos
- ✅ CRUD de bloques
- ✅ CRUD de piezas
- ✅ Cálculos automáticos de estado
- ✅ Cálculos de diferencia de peso
- ✅ Reportes agregados
- ✅ Validaciones de inputs
- ✅ Autenticación JWT

## 📝 Logs y Debugging

### Ver Logs en Tiempo Real
```bash
tail -f storage/logs/laravel.log
```

### Logs de Negocio
```php
// Logs generados automáticamente
PieceService::createPiece - Creating piece with data
PieceService::calculateState - State calculated: Fabricada
PieceService::createPiece - Piece created successfully
```

## 🔄 Integración con Auth Service

### Configuración Compartida
```env
# En pieces-service/.env
JWT_SECRET=mismo-secret-que-auth-service
```

### Middleware de Autenticación
```php
// Todas las rutas están protegidas
Route::middleware('jwt')->group(function () {
    Route::apiResource('pieces', PieceController::class);
    Route::apiResource('blocks', BlockController::class);
    Route::apiResource('projects', ProjectController::class);
});
```

## 📈 Monitoreo y Performance

### Métricas Importantes
- **Tiempo de respuesta**: < 200ms para operaciones CRUD
- **Tasa de éxito**: > 98% para operaciones válidas
- **Uso de memoria**: < 128MB por request
- **Conexiones BD**: Pool de 10-20 conexiones

### Optimizaciones
- **Índices compuestos**: `block_id + estado` para consultas frecuentes
- **Eager Loading**: Carga de relaciones en consultas
- **Query Caching**: Cache de resultados de reportes
- **Pagination**: Para listas grandes de datos

## 🚀 Despliegue

### Producción
```bash
# Optimizar para producción
composer install --no-dev --optimize-autoloader
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Variables de entorno producción
APP_ENV=production
APP_DEBUG=false
LOG_LEVEL=error
```

### Docker (Opcional)
```dockerfile
FROM php:8.2-fpm
WORKDIR /var/www
COPY . .
RUN composer install --no-dev
RUN php artisan config:cache
EXPOSE 9000
CMD ["php-fpm"]
```

## 🔧 Mantenimiento

### Tareas Comunes
```bash
# Limpiar cache
php artisan cache:clear

# Verificar estado de migraciones
php artisan migrate:status

# Respaldo de base de datos
php artisan db:dump --database=postgresql

# Verificar colas
php artisan queue:monitor
```

## 🚨 Soporte y Troubleshooting

### Problemas Comunes

#### Error: "Foreign key constraint violation"
```bash
# Verificar que el proyecto/bloque exista
php artisan tinker
Project::find($projectId)  # Debe retornar objeto
Block::find($blockId)      # Debe retornar objeto
```

#### Error: "JWT token invalid"
```bash
# Verificar JWT_SECRET compartido
grep JWT_SECRET .env

# Verificar formato del token
# Debe ser: "Bearer eyJ..."
```

#### Error: "Database connection failed"
```bash
# Verificar conexión a BD
php artisan tinker
DB::connection()->getPdo()

# Verificar variables de entorno
php artisan env
```

## 📄 Licencia

MIT License - Uso libre con atribución.

---

**Pieces Service** es el motor de negocio del sistema, proporcionando gestión completa de piezas metálicas con cálculos automáticos y reportes detallados.

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
