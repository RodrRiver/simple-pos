# SimplePOS

Sistema de punto de venta e inventario open-source, diseñado para pequeños negocios en Latinoamérica.

![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=flat-square&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?style=flat-square&logo=php&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind-3.4-06B6D4?style=flat-square&logo=tailwindcss&logoColor=white)
![License](https://img.shields.io/badge/Licencia-MIT-green?style=flat-square)

---

## Características

- **Punto de Venta (POS)** — Pantalla completa con grilla de productos, carrito, escáner de código de barras, descuentos, y modal de pago con efectivo/tarjeta/transferencia
- **Gestión de Productos** — CRUD completo con categorías, imágenes, precios, costos, SKU y códigos de barras
- **Control de Inventario** — Niveles de stock con alertas, ajustes manuales (entrada/salida/corrección), historial de movimientos con auditoría completa
- **Recibos** — Recibos impresos en HTML y soporte para impresoras térmicas (58mm/80mm)
- **Reportes** — Ventas por período, productos más vendidos, análisis de ganancias con márgenes
- **Dashboard** — Resumen diario, gráfico de ventas semanal, alertas de stock bajo, ventas recientes
- **Roles** — Administrador y cajero con permisos diferenciados
- **Configuración** — Información del negocio, logo, pie de recibo, impuestos, moneda
- **Interfaz en español** — Diseñada para negocios en El Salvador y Centroamérica, con precios en USD

---

## Requisitos

- PHP 8.3+
- Composer
- Node.js 20+
- MySQL 8.0+ o MariaDB 10.11+

---

## Instalación

### 1. Clonar el repositorio

```bash
git clone https://github.com/TU_USUARIO/simple-pos.git
cd simple-pos
```

### 2. Instalar dependencias

```bash
composer install
npm install && npm run build
```

### 3. Configurar el entorno

```bash
cp .env.example .env
php artisan key:generate
```

Edita el archivo `.env` con tus credenciales de base de datos:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=simplepos
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

### 4. Crear la base de datos y ejecutar migraciones

```bash
mysql -u root -e "CREATE DATABASE simplepos"
php artisan migrate --seed
```

### 5. Crear el enlace de almacenamiento

```bash
php artisan storage:link
```

### 6. Iniciar el servidor

```bash
php artisan serve
```

Abre **http://localhost:8000** en tu navegador.

---

## Credenciales de demostración

| Rol          | Correo                  | Contraseña |
|--------------|-------------------------|------------|
| Administrador | admin@simplepos.test   | password   |
| Cajero        | cajero@simplepos.test  | password   |

---

## Estructura del proyecto

```
simple-pos/
├── app/
│   ├── Enums/            # Role, PaymentMethod, SaleStatus, etc.
│   ├── Http/
│   │   ├── Controllers/  # POS, productos, inventario, reportes
│   │   ├── Middleware/    # EnsureUserIsAdmin
│   │   └── Requests/     # Validación de formularios
│   ├── Models/           # User, Product, Sale, Category, etc.
│   └── Services/         # SaleService, InventoryService
├── database/
│   ├── migrations/       # 7 tablas
│   └── seeders/          # Datos de demostración
├── resources/views/
│   ├── pos/              # Pantalla de punto de venta
│   ├── products/         # CRUD de productos
│   ├── sales/            # Historial y recibos
│   ├── inventory/        # Gestión de inventario
│   ├── reports/          # Reportes
│   └── settings/         # Configuración
└── routes/web.php        # Todas las rutas
```

---

## Stack tecnológico

| Componente    | Tecnología         |
|---------------|--------------------|
| Backend       | Laravel 11         |
| Frontend      | Blade + Alpine.js  |
| Estilos       | Tailwind CSS       |
| Base de datos | MySQL / MariaDB    |
| Gráficos      | Chart.js           |

---

## Despliegue en Google Cloud Run

El proyecto incluye un `Dockerfile` listo para desplegar:

```bash
gcloud run deploy simple-pos \
  --source . \
  --region us-central1 \
  --allow-unauthenticated \
  --port 8080
```

Configura las variables de entorno en Cloud Run para la conexión a Cloud SQL.

---

## Roadmap

- [ ] Soporte multi-sucursal
- [ ] Base de datos de clientes
- [ ] Gestión de proveedores
- [ ] Variantes de productos (tamaño, sabor)
- [ ] Envío de recibos por WhatsApp
- [ ] API para aplicación móvil
- [ ] Soporte multi-idioma
- [ ] Integración con DTE (factura electrónica El Salvador)

---

## Contribuir

Las contribuciones son bienvenidas. Por favor:

1. Haz fork del repositorio
2. Crea una rama para tu feature (`git checkout -b feature/nueva-funcionalidad`)
3. Commit tus cambios (`git commit -m 'Agregar nueva funcionalidad'`)
4. Push a la rama (`git push origin feature/nueva-funcionalidad`)
5. Abre un Pull Request

---

## Licencia

Este proyecto está bajo la [Licencia MIT](LICENSE).
