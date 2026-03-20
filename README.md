# ⚡ Catálogo Digital — SER Electrónica

Aplicación web desarrollada en **Laravel** para la gestión y visualización del catálogo de productos de **SER Electrónica**, empresa ubicada en Mendoza dedicada a la venta de electrónica, audio y componentes.

El sistema funciona como un **catálogo digital** (no e-commerce transaccional): los clientes exploran productos y finalizan la consulta o compra directamente por **WhatsApp**.

---

## 🎨 Sistema de Diseño

### Paleta de Colores

El proyecto usa **CSS Variables** para gestión centralizada de colores, siguiendo la regla **60–20–10–10**:

| Variable | Valor | Uso |
|---|---|---|
| `--bg` | `#2A4941` | 60% — Fondo principal (Verde Bosque) |
| `--surface` | `#33524A` | 20% — Superficies / Cards |
| `--surface-2` | `#3C5F56` | Superficies secundarias |
| `--surface-3` | `#1E3630` | Superficies oscuras |
| `--text` | `#F0EAD6` | 10% — Texto principal (Beige claro) |
| `--text-2` | `#DCD0BA` | Texto secundario (Beige original) |
| `--text-3` | `#A89F8E` | Texto terciario / Placeholders |
| `--lime` | `#DCD0BA` | 10% — Color de acento principal (Beige) |
| `--lime-dim` | `rgba(220,208,186,0.10)` | Acento con opacidad baja |
| `--lime-glow` | `rgba(220,208,186,0.25)` | Acento con glow |
| `--lime-dark` | `#C4B8A0` | Acento oscuro (hover) |
| `--border` | `rgba(220,208,186,0.15)` | Bordes translúcidos |
| `--border-solid` | `#DCD0BA` | Bordes sólidos |
| `--danger` | `#DC2626` | Errores / Eliminar |
| `--success` | `#16A34A` | Éxito / Activo |
| `--warning` | `#D97706` | Advertencias |

> **Concepto visual**: "Circuit Navy #0C1A2B · Solar Lime #B6FF3B" — sensación premium de electrónica industrial.

### Tipografías

| Variable | Fuente | Uso |
|---|---|---|
| `--font-display` | `Barlow Condensed` | Títulos, navbar, headings |
| `--font-body` | `Barlow` | Texto general, botones |
| `--font-mono` | `Fira Code` | Labels de sección, etiquetas técnicas |

### Efectos y Animaciones

- **Patrón de circuito** sutil en el fondo (`body::before`) con grid de líneas finas
- **Navbar sticky** con `backdrop-filter: blur(20px)` — efecto glassmorphism
- **Menú mobile** con animación `slideIn` desde la derecha
- **Transiciones estándar** `0.22s cubic-bezier(0.4, 0, 0.2, 1)` en todos los elementos interactivos
- **Toast notifications** con animación `slideIn/slideOut` y barra de progreso
- **Footer collapsible** en móvil (secciones con toggle)

### Breakpoints Responsive

| Breakpoint | Ancho | Comportamiento |
|---|---|---|
| Desktop XL | ≥ 1920px | Padding lateral 15vw |
| Desktop LG | ≥ 1400px | Padding lateral 10vw |
| Tablet | ≤ 1024px | Footer en columna única, navbar hamburguesa |
| Tablet SM | ≤ 960px | Catálogo: 1 columna, sidebar collapsible |
| Mobile | ≤ 820px | Menú hamburguesa |
| Mobile SM | ≤ 600px | Grid 2 columnas, toolbar apilado |

---

## 🚀 Funcionalidades

### 🌐 Parte Pública (Catálogo)

#### Página de Inicio (`/`)
- Hero section con productos destacados
- Sección de promociones activas vigentes (máx. 5)
- Acceso rápido a todas las categorías

#### Catálogo (`/catalogo`)
- **Búsqueda parcial inteligente**: encuentra productos aunque la palabra no sea exacta, busca en nombre, descripción, marca, modelo y categoría
- **Filtro por categoría** con contador de productos activos por categoría
- **Filtro por rango de precios** que considera tanto el precio base como el **precio con promoción aplicada** (porcentaje o monto fijo)
- **Ordenamiento**: por precio ascendente/descendente, por nombre A-Z, y por más recientes
- **Paginación** de 12 productos por página

#### Detalle de Producto (`/producto/{slug}`)
- Galería de imágenes con miniaturas
- Visualización de precio base y precio con descuento
- Especificaciones técnicas (marca, modelo, categoría)
- Sección de **productos relacionados** (misma categoría, máx. 4)
- Botón de **WhatsApp** con mensaje predefinido incluyendo el nombre del producto

#### Promociones Públicas (`/promociones`)
- Listado de promociones activas con fechas de vigencia
- Productos en oferta con precio tachado y precio final resaltado

#### Soporte Técnico (`/soporte-tecnico`)
- Página informativa de soporte

### 🛡️ Panel de Administración (Backoffice)

> Todas las rutas del panel requieren autenticación (`auth:sanctum`) y rol administrador (`admin`).

#### Dashboard (`/admin/dashboard`)
- Estadísticas rápidas: total de productos, categorías, promociones activas y productos **sin imagen**
- Últimos 5 productos cargados
- Próximas 5 promociones a vencer

#### Gestión de Productos (`/admin/productos`)
- **CRUD completo**: Crear, Ver, Editar, Eliminar
- Carga de **galería de múltiples imágenes** con Drag & Drop
- Eliminación individual de imágenes de galería
- **Toggle activo/oculto** con un click (PATCH rápido)
- Campo **destacado** para mostrar en la home
- Soporte para slug automático y campo de marca/modelo
- **Importación masiva desde Excel/CSV** (`/admin/productos/import`)

#### Gestión de Categorías (`/admin/categorias`)
- **CRUD completo**: Crear, Ver, Editar, Eliminar
- Soporte para icono/emoji por categoría
- Slug automático
- **Importación masiva desde Excel/CSV** (`/admin/categorias/import`)

#### Sistema de Promociones (`/admin/promociones`)
- **CRUD completo**: Crear, Editar, Eliminar
- Descuento por **porcentaje (%)** o **monto fijo ($)**
- Programación de **fecha de inicio y fecha de fin**
- Aplicación a productos individuales o a **categorías enteras**
- **Toggle activo/inactivo** vía POST o PATCH
- Vista pública de promociones vigentes

---

## 🛠️ Tecnologías

| Capa | Tecnología |
|---|---|
| Backend | PHP 8.x, Laravel 10/11 |
| Frontend | Blade Templates, Vanilla JS, CSS Variables |
| Base de datos | MySQL |
| Autenticación | Laravel Sanctum (web + API) |
| Build tool | Vite |
| Importación | `maatwebsite/excel` |
| Imágenes | `intervention/image` |

---

## ⚙️ Instalación Local

```bash
# 1. Clonar el repositorio
git clone <url-del-repositorio>
cd catalogo-electronica

# 2. Instalar dependencias PHP
composer install

# 3. Instalar dependencias Node
npm install

# 4. Configurar entorno
cp .env.example .env
# → Editar .env con tus credenciales de base de datos

# 5. Generar clave de aplicación
php artisan key:generate

# 6. Ejecutar migraciones
php artisan migrate

# 7. Vincular storage (necesario para imágenes)
php artisan storage:link

# 8. Compilar assets CSS/JS
npm run build

# 9. Levantar servidor
php artisan serve
```

Para desarrollo con hot-reload de assets:
```bash
npm run dev
```

---

## 👤 Acceso y Roles

El sistema tiene dos roles: `admin` y usuario regular.

Para acceder al panel de administración, el campo `is_admin` de la tabla `users` debe estar en `1`.

### Crear usuario admin vía tinker

```bash
php artisan tinker
```
```php
\App\Models\User::create([
    'name'     => 'Admin',
    'email'    => 'admin@serelectronica.com',
    'password' => bcrypt('tu_contraseña'),
    'is_admin' => true,
]);
```

### Rutas de acceso

| Sección | URL |
|---|---|
| Catálogo público | `/` o `/catalogo` |
| Promociones | `/promociones` |
| Soporte | `/soporte-tecnico` |
| Login | `/login` |
| Admin Dashboard | `/admin/dashboard` |
| Admin Productos | `/admin/productos` |
| Admin Categorías | `/admin/categorias` |
| Admin Promociones | `/admin/promociones` |
| Importar Productos | `/admin/productos/import` |
| Importar Categorías | `/admin/categorias/import` |

---

## 📋 Importación Masiva (Excel / CSV)

El sistema permite importar productos y categorías desde archivos Excel o CSV.

- Acceder a `/admin/productos/import` o `/admin/categorias/import`
- Subir el archivo `.xlsx` o `.csv` con el formato correspondiente
- El sistema procesa cada fila y reporta errores de validación

> Requiere la librería `maatwebsite/excel` instalada vía Composer.

---

## 🏢 Datos de la Empresa

| Campo | Valor |
|---|---|
| Empresa | SER Electrónica |
| Dirección | Lavalle 299, Mendoza, Argentina |
| Teléfono | 0261 337-2353 |
| Contacto | WhatsApp integrado en cada producto |

---

## 📄 Licencia

Software propietario desarrollado exclusivamente para **SER Electrónica**. Todos los derechos reservados.

---

## 🔄 Historial de Cambios

| Versión | Cambio |
|---|---|
| v1.5 | Sistema de importación masiva (Excel/CSV) para productos y categorías |
| v1.4 | Panel de administración con autenticación Sanctum + middleware `admin` |
| v1.3 | Sistema de promociones con descuento por % o monto fijo y programación de fechas |
| v1.2 | Filtro de precio considera precio con promoción aplicada; búsqueda parcial mejorada |
| v1.1 | Scroll infinito, galería de imágenes con Drag & Drop, productos destacados en home |
| v1.0 | Catálogo público, CRUD de productos y categorías, integración WhatsApp |
