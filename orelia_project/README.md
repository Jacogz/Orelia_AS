# Orelia — Tienda de Joyería Artesanal

Orelia es una aplicación web de comercio electrónico para joyería artesanal, construida con **Laravel 12**, **SQLite** y **Bootstrap 5**. Ofrece un catálogo de piezas con conversión de divisas en tiempo real, carrito de compras, checkout y un panel de administración completo.

## Integrantes

| Nombre |
|--------|
| Isabella Hernández Posada |
| Jacobo Giraldo Zuluaga |
| Jeremías Figueroa García |

## Requisitos previos

- PHP 8.4+
- Composer
- Node.js 18+ y npm
- Extensiones PHP: `sqlite3`, `mbstring`, `xml`, `zip`, `curl`

## Instalación local

```bash
# 1. Clonar el repositorio
git clone https://github.com/Jacogz/Orelia_AS.git
cd Orelia_AS/orelia_project

# 2. Instalar dependencias PHP y JS
composer install
npm install && npm run build

# 3. Configurar entorno
cp .env.example .env
php artisan key:generate

# 4. Crear base de datos y cargar datos de prueba
touch database/database.sqlite
php artisan migrate --seed

# 5. Enlazar almacenamiento de imágenes
php artisan storage:link

# 6. Iniciar servidor de desarrollo
php artisan serve
```

La aplicación estará disponible en **http://localhost:8000**

## Cuentas de prueba

| Rol | Email | Contraseña |
|-----|-------|------------|
| Administrador | admin@admin.com | adminpassword |
| Cliente | john.doe@example.com | userpassword |

## Rutas principales

| Ruta | Descripción |
|------|-------------|
| `/` | Página de inicio con catálogo destacado |
| `/pieces` | Catálogo completo de piezas |
| `/collections` | Colecciones de joyería |
| `/materials` | Materiales disponibles |
| `/conversiones` | Conversor de divisas (COP / USD / EUR) |
| `/cart` | Carrito de compras |
| `/admin/dashboard` | Panel de administración (requiere cuenta admin) |
| `/api/pieces` | Servicio REST JSON de piezas en stock |

## Ejecutar con Docker

```bash
docker build -t orelia .
docker run -p 80:80 orelia
```

La aplicación estará disponible en **http://localhost**

## Ejecutar pruebas

```bash
php artisan test
```

## Variables de entorno relevantes

Copia `.env.example` a `.env` y configura según sea necesario:

| Variable | Descripción |
|----------|-------------|
| `EXCHANGE_RATE_API_KEY` | Clave de la API de tasas de cambio (exchangerate-api.com) |
| `GUEST_PRODUCTS_BASE_URL` | URL del servicio del equipo proveedor |
| `IMAGE_STORAGE_DRIVER` | `local` (por defecto) o `gcp` |
