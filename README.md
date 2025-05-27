# Finanzas

Este proyecto es un sistema de gestión financiera personal desarrollado en Laravel. Permite registrar y visualizar:

- **Ingresos**
- **Egresos**
- **Ahorros**
- **Gastos fijos**
- **Períodos financieros**

## Tecnologías

- PHP 8+
- Laravel 12
- MySQL
- Chart.js (para visualizaciones)

## Estructura de tablas

### Ingresos
- `id`, `monto`, `fecha`, `descripcion`, `periodo_id`

### Egresos
- `id`, `monto`, `fecha`, `descripcion`, `periodo_id`

### Ahorros
- `id`, `monto`, `fecha`, `descripcion`, `periodo_id`

### Gastos Fijos
- `id`, `nombre`, `monto`, `frecuencia`, `periodo_id`

### Periodos
- `id`, `fecha_inicio`, `fecha_fin`, `nombre`

## Funcionalidades
- Registro de operaciones financieras
- Visualización de reportes con filtros por fecha y categoría
- Gráficas de ingresos, egresos y balance general
- Exportación de reportes

## Instalación

```bash
git clone https://github.com/xamtam54/finanzas.git
cd finanzas
composer install
cp .env.example .env
php artisan key:generate
# Configura base de datos en .env
php artisan migrate --seed
php artisan serve
