# Proposal

## Why

Los especialistas de la salud (terapeutas, psicólogos, médicos) necesitan una plataforma web moderna para gestionar su práctica: agendado de citas, comunicación con pacientes, contenido educativo y venta de productos. Las soluciones actuales están atadas a una especialidad concreta o gestionan los procesos de forma manual y dispersa. Se requiere una plataforma genérica, configurable por módulos, que cualquier especialista pueda adoptar y adaptar a su práctica activando solo las funcionalidades que necesita.

## What Changes

- **Plataforma genérica multi-especialista (BREAKING)**: El sistema deja de estar atado a hipnoterapia y soporta cualquier especialidad (terapeuta, psicólogo, médico, etc.), con tipo de especialista y servicios configurables.
- **Sistema de módulos activables**: Funcionalidad de primer nivel para activar/desactivar capacidades. Configuración híbrida (defaults en archivo de config + override persistido en BD) gestionable desde el panel de administración.
- **Sitio web público**: Página principal de presentación y página de contacto con información y mapa de ubicación. Activo por defecto.
- **Gestión de citas**: Agendado por usuarios anónimos y registrados, con disponibilidad gestionada por el especialista/admin. Activo por defecto.
- **Gestión de citas del usuario**: Los usuarios registrados pueden gestionar sus propias citas (ver, reprogramar, cancelar). Activo por defecto.
- **Petición de cambio/cancelación para anónimos**: Los usuarios sin registro pueden solicitar cambios o cancelaciones mediante un código/enlace único enviado por email, con validación.
- **Mensajería (messenger)**: Chat 1-a-1 con soporte/especialista en tiempo real. Módulo opcional.
- **Notas clínicas, historia clínica y recetas**: Notas/indicaciones del especialista por cita, historial clínico longitudinal por paciente (antecedentes, evolución, diagnósticos), carga de archivos clínicos (imágenes, videos y documentos como resultados de estudios) y consulta de recetas médicas. El historial es compartido: lo consultan el especialista y el propio paciente. Módulo opcional; el historial, los adjuntos y las recetas solo son consultables si este módulo está activo.
- **Blog/Noticias**: Publicaciones gestionables por el admin. Módulo opcional.
- **Tienda online**: Catálogo, carrito, checkout y gestión de pedidos. Módulo opcional.
- **Autenticación y roles**: Roles de administrador/owner, especialista y paciente, con SSO de Google. Activo por defecto.
- **Notificaciones**: Confirmaciones, recordatorios y avisos de cambio de estado de citas. Activo por defecto.

## Capabilities

### New Capabilities

- **public-site**: Sitio web público con página principal de presentación y página de contacto con mapa. Activo por defecto.
- **auth-roles**: Autenticación con múltiples roles (admin/owner, especialista, paciente), control de permisos y login con Google. Activo por defecto.
- **scheduling**: Gestión de citas, disponibilidad de especialistas, reserva anónima y registrada, y prevención de doble reserva. Activo por defecto.
- **user-appointments**: Área para usuarios registrados donde gestionan sus propias citas (ver, reprogramar, cancelar) y solicitud de cambios por parte de anónimos mediante código/enlace único. Activo por defecto.
- **appointments-notifications**: Notificaciones de citas (confirmación, recordatorios, cambios de estado) por email y en la app. Activo por defecto.
- **module-config**: Configuración híbrida para activar/desactivar módulos, con defaults en archivo y override en BD, gestionable desde el panel de administración.
- **messaging**: Mensajería 1-a-1 con soporte en tiempo real. Módulo opcional.
- **clinical-notes**: Historia clínica del paciente (notas e indicaciones por cita, historial clínico longitudinal, adjuntos de imágenes/videos/documentos) compartida entre el especialista y el paciente, y consulta de recetas médicas (historial y recetas visibles solo si el módulo está activo). Módulo opcional.
- **blog**: Gestión de publicaciones/noticias con CRUD, categorías y publicación programada. Módulo opcional.
- **ecommerce**: Catálogo de productos, carrito, checkout y gestión de pedidos. Módulo opcional.

### Modified Capabilities

- (Ninguna - proyecto rehecho desde cero sin specs previos)

## Impact

- **Frontend**: Aplicación Vue 3 (Composition API) + Vue Router + Pinia + TypeScript. Layout y navegación que reflejan dinámicamente los módulos activos.
- **Backend**: API RESTful con Laravel 11/12 (PHP 8.2+). Control de acceso por roles (Spatie Permission), OAuth con Laravel Socialite, tiempo real con WebSockets (Laravel Reverb/Pusher) para messaging.
- **Base de datos**: MySQL/MariaDB. Migraciones y seeders para roles, admin, configuración de módulos y tipo de especialidad/servicios.
- **Configuración**: Defaults de módulos en `config/modules.php` con override persistido en BD.
- **Almacenamiento**: Disco privado con URLs firmadas y con caducidad para los archivos clínicos (imágenes, videos y documentos de resultados de estudios), con límites de 50 MB para imágenes/documentos y 250 MB para videos; disco público para imágenes de productos, portadas de blog y contenido público.
- **Email**: Notificaciones y códigos/enlaces únicos para gestión de citas anónimas.
- **Arquitectura**: Separación frontend/backend (SPA) con Laravel como API + Sanctum. CORS configurado.
