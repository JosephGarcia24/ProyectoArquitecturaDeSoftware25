# Guía de Instalación - CRUD Empleados Laravel

Esta guía te ayudará a configurar el proyecto después de clonar el repositorio.

## Requisitos Previos

- PHP 8.1 o superior
- Composer
- MySQL o MariaDB
- Node.js y NPM
- XAMPP (o cualquier servidor local con PHP y MySQL)

## Pasos de Instalación

### 1. Clonar el Repositorio

```bash
git clone https://github.com/JosephGarcia24/ProyectoArquitecturaDeSoftware25.git
cd ProyectoArquitecturaDeSoftware25/crud-arq
```

### 2. Instalar Dependencias de PHP

```bash
composer install
```

### 3. Instalar Dependencias de Node.js

```bash
npm install
```

### 4. Configurar el Archivo de Entorno

Copia el archivo de ejemplo `.env.example` a `.env`:

```bash
cp .env.example .env
```

O en Windows:
```bash
copy .env.example .env
```

### 5. Configurar las Variables de Entorno

Edita el archivo `.env` y configura los siguientes valores:

```env
APP_NAME="CRUD Empleados"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=proyecto_crud_arquitectura
DB_USERNAME=root
DB_PASSWORD=
```

**Nota importante:** Los valores con espacios deben ir entre comillas dobles, como `APP_NAME="CRUD Empleados"`.

### 6. Generar la Clave de Aplicación

```bash
php artisan key:generate
```

### 7. Crear la Base de Datos

Abre phpMyAdmin (normalmente en `http://localhost/phpmyadmin`) y crea una nueva base de datos llamada `proyecto_crud_arquitectura`.

O desde la línea de comandos de MySQL:

```sql
CREATE DATABASE proyecto_crud_arquitectura;
```

### 8. Ejecutar las Migraciones

```bash
php artisan migrate
```

### 9. (Opcional) Poblar la Base de Datos con Datos de Prueba

```bash
php artisan db:seed
```

### 10. Compilar los Assets de Frontend

Para desarrollo:
```bash
npm run dev
```

O para producción:
```bash
npm run build
```

### 11. Iniciar el Servidor de Desarrollo

En una terminal, ejecuta:

```bash
php artisan serve
```

Si usas Composer scripts, también puedes usar el siguiente comando para correr ambas partes:
```bash
composer run dev
```

El servidor estará disponible en: `http://localhost:8000`

## Solución de Problemas Comunes

### Error: "The environment file is invalid"

Esto ocurre cuando hay valores con espacios sin comillas en el `.env`. Asegúrate de que valores como `APP_NAME` estén entre comillas:

```env
APP_NAME="CRUD Empleados"
```

### Error: "SQLSTATE[HY000] [1045] Access denied"

Verifica que las credenciales de la base de datos en `.env` sean correctas:
- `DB_USERNAME` (normalmente `root` en XAMPP)
- `DB_PASSWORD` (normalmente vacío en XAMPP)

### Error: "Base table or view not found"

Ejecuta las migraciones:

```bash
php artisan migrate
```

### Los estilos no cargan correctamente

Asegúrate de haber ejecutado:

```bash
npm install
npm run dev
```

### Error de permisos en storage/

En Linux/Mac, ejecuta:

```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

## Comandos Útiles

```bash
# Limpiar caché
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Refrescar la base de datos (¡CUIDADO! Elimina todos los datos)
php artisan migrate:fresh --seed

# Ver rutas disponibles
php artisan route:list

# Ejecutar tests
php artisan test
```

## Estructura del Proyecto

```
crud-arq/
├── app/
│   ├── Http/Controllers/
│   │   └── EmpleadoController.php
│   └── Models/
│       └── Empleado.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
│       └── empleados/
│           ├── index.blade.php
│           ├── create.blade.php
│           ├── edit.blade.php
│           └── show.blade.php
└── routes/
    └── web.php
```

## Funcionalidades Implementadas

- ✅ CRUD completo de empleados
- ✅ Búsqueda de empleados (nombre, email, departamento)
- ✅ Selección múltiple y eliminación masiva
- ✅ Paginación de resultados
- ✅ Validación de formularios
- ✅ Mensajes de éxito/error
- ✅ Interfaz responsive con Tailwind CSS

## Soporte

Si encuentras algún problema, contacta al equipo o crea un issue en el repositorio.
