# Cuchubal App Backend

## Descripción
Backend para la aplicación Cuchubal, diseñado para manejar participantes, contribuciones, pagos, usuarios, y más. Este backend utiliza PHP y una arquitectura basada en servicios.

## Estructura del Proyecto
```
backend/
├── auth/
│   └── authMiddleware.php
├── db/
│   ├── cuchubal.sql
│   └── database.php
├── models/
│   ├── Contribution.php
│   ├── Cuchubal.php
│   ├── Participant.php
│   ├── Payment.php
│   ├── PaymentSchedule.php
│   └── User.php
├── services/
│   ├── contributionService.php
│   ├── cuchubalService.php
│   ├── participantService.php
│   ├── paymentScheduleService.php
│   ├── paymentService.php
│   └── userService.php
├── vendor/
│   ├── altorouter/
│   └── composer/
├── .htaccess
├── composer.json
├── composer.lock
└── router.php
```

## Requisitos
- PHP 7.4 o superior
- MySQL o MariaDB
- Composer

## Instalación
1. Clonar el repositorio.
2. Ejecutar `composer install` para instalar las dependencias.
3. Configurar la base de datos usando `db/cuchubal.sql`.
4. Configurar los parámetros de conexión a la base de datos en `db/database.php`.

## Uso
Para iniciar el servidor backend, use un servidor web como Apache o Nginx. Asegúrese de que el archivo `router.php` esté configurado como el punto de entrada para las solicitudes HTTP.

## Rutas API
Este backend ofrece diversas rutas API para manejar diferentes recursos:

### Participantes
- `GET /participants/cuchubal/[i:cuchubalId]`: Listar participantes activos por Cuchubal.
- `POST /participants`: Crear un nuevo participante.
- `PUT /participants/[i:id]`: Actualizar un participante.
- `DELETE /participants/[i:id]`: Eliminar un participante.

### Usuarios
- `GET /users`: Listar todos los usuarios.
- `GET /users/[i:id]`: Obtener detalles de un usuario específico.
- `POST /users`: Crear un nuevo usuario.
- `PUT /users/[i:id]`: Actualizar un usuario.
- `DELETE /users/[i:id]`: Eliminar un usuario.

### Pagos
- `GET /payments/cuchubal/[i:cuchubalId]`: Listar pagos por Cuchubal.
- `GET /payments/[i:id]`: Obtener detalles de un pago.
- `POST /payments`: Procesar un nuevo pago.

### Contribuciones
- `GET /contributions`: Listar contribuciones activas.
- `POST /contributions`: Añadir una nueva contribución.

### Cuchubales
- `GET /cuchubales`: Listar Cuchubales por usuario.
- `POST /cuchubales`: Crear un nuevo Cuchubal.

### Autenticación
- `POST /login`: Iniciar sesión.
- `GET /logout`: Cerrar sesión.

## Seguridad
Este proyecto utiliza un middleware de autenticación para proteger las rutas sensibles. Se requiere autenticación para acceder a la mayoría de las rutas.

## Contribuir
Las contribuciones son bienvenidas. Por favor, envíe un Pull Request o abra un issue para discutir los cambios propuestos.
