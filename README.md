# ⚡ Catálogo Digital - SER Electrónica

Este proyecto es una aplicación web desarrollada en **Laravel** para la gestión y visualización del catálogo de productos de **SER Electrónica**, una empresa ubicada en Mendoza dedicada a la venta de electrónica, audio y componentes.

El sistema funciona como un **catálogo digital** (no e-commerce transaccional), diseñado para que los clientes exploren productos y finalicen la consulta o compra a través de **WhatsApp**.

---

## 🎨 Sistema de Diseño

### Paleta de Colores

El proyecto utiliza un sistema de **CSS Variables** para una gestión centralizada de colores:

| Variable | Color | Uso |
|----------|-------|-----|
| `--bg` | `#2A4941` | Fondo principal (Verde Bosque) |
| `--surface` | `#33524A` | Superficies / Cards |
| `--surface-2` | `#3C5F56` | Superficies secundarias |
| `--surface-3` | `#1E3630` | Superficies oscuras |
| `--text` | `#F0EAD6` | Texto principal (Beige claro sobre verde) |
| `--text-2` | `#DCD0BA` | Texto secundario (Beige original) |
| `--text-3` | `#A89F8E` | Texto terciario / Placeholders |
| `--lime` | `#DCD0BA` | Color de acento principal (Beige) |
| `--lime-dim` | `rgba(220,208,186,0.1)` | Acento con opacidad |
| `--lime-glow` | `rgba(220,208,186,0.25)` | Acento brillante |
| `--lime-dark` | `#C4B8A0` | Acento oscuro |
| `--border` | `rgba(220,208,186,0.15)` | Bordes |
| `--border-solid` | `#3D5C52` | Bordes sólidos |

#### Escala de Colores
- **60%** → Fondo principal (`--bg`)
- **20%** → Superficies / Cards (`--surface`)
- **10%** → Texto (`--text`)
- **10%** → Acento (`--lime`)

### Tipografías

- **Display/Fuentes principales**: Variables CSS `--font-display` y `--font-body`
- **Sistema de sizing fluido** con `clamp()` para escalado automático

### Breakpoints Responsive

| Breakpoint | Ancho | Comportamiento |
|------------|-------|----------------|
| **Desktop XL** | ≥1920px | Padding máximo (15vw) |
| **Desktop LG** | ≥1400px | Padding grande (10vw) |
| **Tablet** | ≤1024px | Footer en 2 columnas |
| **Tablet SM** | ≤960px | Catálogo: 1 columna, sidebar collapsible |
| **Mobile** | ≤820px | Navbar: menú hamburguesa |
| **Mobile SM** | ≤600px | Catálogo: toolbar apilado, grid 2 columnas |

---

## 🚀 Características Principales

### 🛒 Parte Pública (Catálogo)
* **Buscador y Filtros:** 
  * Búsqueda parcial por nombre, descripción, marca, modelo y categoría.
  * Filtrado por categorías.
  * Filtrado por rango de precios (incluye precios con promoción).
  * Ordenamiento por precio (asc/desc), nombre y recientes.
* **Scroll Infinito:** Carga dinámica de productos para una navegación fluida.
* **Detalle de Producto:**
  * Galería de imágenes con miniaturas.
  * Visualización de precios y descuentos.
  * Especificaciones técnicas (Marca, Modelo).
  * Productos relacionados.
* **Integración con WhatsApp:** Botón directo que genera un mensaje predefinido con el nombre del producto de interés.
* **Promociones:** Visualización de ofertas activas con fechas de vigencia automática.

### 🛡️ Panel de Administración (Backoffice)
* **Dashboard:** Estadísticas rápidas de productos, categorías y promociones activas.
* **Gestión de Productos:**
  * CRUD completo (Crear, Leer, Actualizar, Eliminar).
  * Carga de múltiples imágenes (Galería) con *Drag & Drop*.
  * Control de stock/visibilidad (Activo/Oculto/Destacado).
* **Gestión de Categorías:** Organización de productos con soporte para iconos/emojis.
* **Sistema de Promociones:**
  * Creación de descuentos por porcentaje (%) o monto fijo ($).
  * Programación de fechas de inicio y fin.
  * Aplicación masiva a productos o categorías enteras.
* **Importación Masiva:** Carga de productos y categorías desde archivos Excel/CSV.

---

## 🛠️ Tecnologías Utilizadas

* **Backend:** PHP 8.x, Laravel 10/11.
* **Frontend:** Blade Templates, Vanilla JavaScript, CSS personalizado (Variables CSS).
* **Base de Datos:** MySQL.
* **Autenticación:** Laravel Sanctum (para API y Web).
* **Build Tool:** Vite.
* **Librerías Clave:**
  * `maatwebsite/excel`: Para importación de datos.
  * `intervention/image` (implícito en el manejo de imágenes).

---

## ⚙️ Instalación y Configuración

Sigue estos pasos para levantar el proyecto en un entorno local:

1.  **Clonar el repositorio:**
    ```bash
    git clone <url-del-repositorio>
    cd catalogo-electronica
    ```

2.  **Instalar dependencias de PHP:**
    ```bash
    composer install
    ```

3.  **Instalar dependencias de Node:**
    ```bash
    npm install
    ```

4.  **Configurar entorno:**
    *   Duplica el archivo `.env.example` y renómbralo a `.env`.
    *   Configura las credenciales de tu base de datos en el `.env`.

5.  **Generar clave de aplicación:**
    ```bash
    php artisan key:generate
    ```

6.  **Ejecutar migraciones:**
    ```bash
    php artisan migrate
    ```

7.  **Vincular el almacenamiento (Importante para las imágenes):**
    ```bash
    php artisan storage:link
    ```

8.  **Compilar assets (CSS/JS):**
    ```bash
    npm run build
    ```

9.  **Iniciar el servidor:**
    ```bash
    php artisan serve
    ```

---

## 👤 Usuarios y Roles

El sistema cuenta con roles de usuario (Admin y User). Para acceder al panel de administración:

1.  Regístrate en `/login` o crea un usuario mediante *tinker*.
2.  Asegúrate de que el campo `is_admin` en la tabla `users` esté en `1` (true).

**Rutas de acceso:**
*   **Catálogo:** `/` o `/catalogo`
*   **Login:** `/login`
*   **Admin Dashboard:** `/admin/dashboard`

---

## 🏢 Información de la Empresa

Datos configurados en las vistas del proyecto:

*   **Empresa:** SER Electrónica
*   **Dirección:** Lavalle 299, Mendoza, Argentina.
*   **Teléfono:** 0261 337-2353
*   **Contacto:** Vía WhatsApp integrado en cada producto.

---

## 📄 Licencia

Este proyecto es software propietario desarrollado para SER Electrónica.

---

## 🔄 Últimas Actualizaciones

- ✅ Búsqueda parcial implementada (encuentra productos aunque la palabra no sea exacta)
- ✅ Filtro de precio incluye precios con promoción
- ✅ Scroll independiente del sidebar corregido en móvil
- ✅ Diseño responsive optimizado para todos los dispositivos
