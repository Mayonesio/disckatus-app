# Disckatus - Gestión de Equipo de Ultimate Frisbee

## Descripción
Aplicación web para la gestión integral de equipos de Ultimate Frisbee, incluyendo gestión de miembros, torneos, pagos y estadísticas.

## Tecnologías
- Laravel 10.x
- Firebase Authentication
- Tailwind CSS
- Blade Templates

## Estructura del Proyecto

### Módulos Principales
1. **Gestión de Usuarios**
   - Autenticación con Firebase/Google
   - Sistema de roles (captain, player)
   - Perfiles detallados de jugadores

2. **Dashboard**
   - Estadísticas generales
   - Próximos torneos
   - Estado de pagos
   - Calendario de entrenamientos

3. **Gestión de Miembros**
   - CRUD completo de miembros
   - Perfiles detallados
   - Estadísticas individuales
   - Gestión de habilidades y lanzamientos

4. **Torneos** (Pendiente)
   - Registro de torneos
   - Gestión de equipos
   - Resultados y estadísticas

5. **Pagos** (Pendiente)
   - Control de cuotas
   - Estado de pagos
   - Recordatorios automáticos

### Estado Actual
- ✅ Sistema base implementado
- ✅ Autenticación funcional
- ✅ Gestión de miembros completa
- ✅ Dashboard básico
- ❌ Sistema de torneos
- ❌ Sistema de pagos
- ❌ Gestión avanzada de roles

## Instalación y Configuración

### Requisitos
- PHP 8.1+
- Composer
- Node.js & NPM
- Firebase Project
- MySQL/PostgreSQL

### Pasos de Instalación
1. Clonar repositorio
2. `composer install`
3. `npm install`
4. Copiar .env.example a .env
5. Configurar variables de entorno
6. `php artisan key:generate`
7. `php artisan migrate`
8. `npm run dev`

## Desarrollo

### Convenciones
- PSR-12 para PHP
- BEM para CSS
- Commits semánticos

### Flujo de Trabajo
1. Crear rama feature/fix
2. Desarrollar
3. Tests
4. Pull Request
5. Code Review
6. Merge

## Próximos Pasos
1. Implementar sistema completo de torneos
2. Desarrollar módulo de pagos
3. Mejorar UX/UI del dashboard
4. Implementar notificaciones
5. Optimizar consultas y rendimiento

## Contribución
[Guías de contribución]

## Licencia
[Tipo de licencia]