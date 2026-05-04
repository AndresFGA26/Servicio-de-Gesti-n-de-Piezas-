# Servicio-de-Gestión-de-Piezas-
🏗️ Pieces Management System - Full-Stack Microservices

Sistema profesional de gestión de piezas metálicas construido con arquitectura de microservicios, utilizando React + TypeScript en el frontend y Laravel + PostgreSQL (Supabase) en el backend.

🔗 Repositorios del Proyecto

Este proyecto está dividido en 3 repositorios independientes, cumpliendo con el enfoque de microservicios:

🔐 Auth Service (Laravel)
👉 https://github.com/AndresFGA26/Servicio-de-autenticaci-n-para-gesti-n-de-piezas.git
📦 Pieces Service (Laravel)
👉 https://github.com/AndresFGA26/Servicio-de-Gesti-n-de-Piezas-.git
🎨 Frontend (React + TypeScript)
👉 https://github.com/AndresFGA26/gestion-de-piezas-front.git
📋 Resumen del Proyecto

Sistema empresarial para la gestión industrial de piezas metálicas con:

🔐 Autenticación con JWT + Refresh Token
📊 Gestión jerárquica: Proyectos → Bloques → Piezas
⚡ Cálculos automáticos de peso y estado
🎨 Frontend moderno con React 19 + TypeScript
🚀 Backend con Laravel + Supabase (PostgreSQL)
📡 API REST versionada (/api/v1)
🔄 CRUD completo en todas las entidades
📈 Reportes con métricas y gráficos
🏗️ Arquitectura General
Frontend (React)
     │
     ├───────────────► Auth Service (Laravel)
     │                   │
     │                   ▼
     │               JWT Token
     │
     └───────────────► Pieces Service (Laravel)
                         │
                         ▼
                 Supabase (PostgreSQL)
🧩 Componentes del Sistema
🔐 Auth Service
Login con JWT
Refresh Token
Logout
Middleware de autenticación
Manejo de errores HTTP
📦 Pieces Service
CRUD de:
Proyectos
Bloques
Piezas
Relación jerárquica completa
Validaciones backend
Paginación y filtros
Reportes globales
🎨 Frontend
React 19 + TypeScript
Estado global con Zustand
React Query (cache y sincronización)
Axios con interceptores JWT
UI moderna con TailwindCSS
Manejo de errores y loading states
🛠️ Tecnologías Utilizadas
Frontend
React 19
TypeScript
TailwindCSS
Axios
React Query
Zustand
Backend
Laravel 11+
PostgreSQL (Supabase)
JWT Authentication
Eloquent ORM
🔐 Autenticación

Sistema basado en:

Access Token (JWT)
Refresh Token
Middleware de protección
Interceptores automáticos en frontend
🔑 Credenciales de Prueba
Email:    admin@test.com
Password: 12345678
🚀 Instalación (Resumen)

Cada servicio tiene su propio README con instrucciones detalladas.

Orden recomendado:
Levantar Auth Service
Levantar Pieces Service
Levantar Frontend
📡 Endpoints Principales
Auth Service
POST /api/v1/login
POST /api/v1/refresh
POST /api/v1/logout
Pieces Service
GET /api/v1/projects
POST /api/v1/projects
GET /api/v1/projects/{id}/blocks
POST /api/v1/blocks/{id}/pieces
GET /api/v1/pieces
GET /api/v1/reports/pieces
📊 Estado del Proyecto (Auditoría)
Área	Estado
Backend Auth	✅ Completo
Backend Pieces	✅ Completo
Frontend	✅ Completo
Reportes	✅ Implementado
Arquitectura MS	⚠️ Parcial (BD compartida)
Seguridad	⚠️ Básica
Testing	❌ No implementado
🚀 Fortalezas
✔ CRUD completo funcional
✔ Arquitectura desacoplada
✔ UI profesional
✔ Uso de tecnologías modernas
✔ Manejo de estados y errores
⚠️ Limitaciones
Base de datos compartida
No hay API Gateway
No hay testing automatizado
Seguridad básica (sin rate limiting)
Sin despliegue automatizado
🎯 Evaluación Técnica

✔ Proyecto defendible en entrevista Junior/Mid
✔ Demuestra conocimientos de:

Microservicios
APIs REST
Frontend moderno
Backend con Laravel
📝 Conclusión

El sistema cumple con los requisitos funcionales y técnicos de la prueba, ofreciendo una solución completa, estructurada y lista para evaluación técnica.
