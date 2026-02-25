nuevos colores 
Beige: #DCD0BA
Verde Bosque: #2A4941

imagen del negocion sin cartel
agregar apartado de servicio tecnico
sacar envios


# ⚡ Catálogo Digital - SER Electrónica

Este proyecto es una aplicación web desarrollada en **Laravel** para la gestión y visualización del catálogo de productos de **SER Electrónica**, una empresa ubicada en Mendoza dedicada a la venta de electrónica, audio y componentes.

El sistema funciona como un **catálogo digital** (no e-commerce transaccional), diseñado para que los clientes exploren productos y finalicen la consulta o compra a través de **WhatsApp**.

---

## 🚀 Características Principales

### 🛒 Parte Pública (Catálogo)
*   **Buscador y Filtros:** Búsqueda por nombre, filtrado por categorías y rangos de precio.
*   **Scroll Infinito:** Carga dinámica de productos para una navegación fluida.
*   **Detalle de Producto:**
    *   Galería de imágenes con miniaturas.
    *   Visualización de precios y descuentos.
    *   Especificaciones técnicas (Marca, Modelo).
    *   Productos relacionados.
*   **Integración con WhatsApp:** Botón directo que genera un mensaje predefinido con el nombre del producto de interés.
*   **Promociones:** Visualización de ofertas activas con fechas de vigencia automática.

### 🛡️ Panel de Administración (Backoffice)
*   **Dashboard:** Estadísticas rápidas de productos, categorías y promociones activas.
*   **Gestión de Productos:**
    *   CRUD completo (Crear, Leer, Actualizar, Eliminar).
    *   Carga de múltiples imágenes (Galería) con *Drag & Drop*.
    *   Control de stock/visibilidad (Activo/Oculto/Destacado).
*   **Gestión de Categorías:** Organización de productos con soporte para iconos/emojis.
*   **Sistema de Promociones:**
    *   Creación de descuentos por porcentaje (%) o monto fijo ($).
    *   Programación de fechas de inicio y fin.
    *   Aplicación masiva a productos o categorías enteras.
*   **Importación Masiva:** Carga de productos y categorías desde archivos Excel/CSV.

---

## 🛠️ Tecnologías Utilizadas

*   **Backend:** PHP 8.x, Laravel 10/11.
*   **Frontend:** Blade Templates, Vanilla JavaScript, CSS personalizado (Variables CSS).
*   **Base de Datos:** MySQL.
*   **Autenticación:** Laravel Sanctum (para API y Web).
*   **Librerías Clave:**
    *   `maatwebsite/excel`: Para importación de datos.
    *   `intervention/image` (implícito en el manejo de imágenes).

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

3.  **Configurar entorno:**
    *   Duplica el archivo `.env.example` y renómbralo a `.env`.
    *   Configura las credenciales de tu base de datos en el `.env`.

4.  **Generar clave de aplicación:**
    ```bash
    php artisan key:generate
    ```

5.  **Ejecutar migraciones:**
    ```bash
    php artisan migrate
    ```

6.  **Vincular el almacenamiento (Importante para las imágenes):**
    ```bash
    php artisan storage:link
    ```

7.  **Iniciar el servidor:**
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
