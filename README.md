# Visor de Documentos

Un sistema web para visualizar y gestionar documentos en diferentes formatos (PDF, EPUB, DOCX) desarrollado con Laravel.

## Características

- Visualización de documentos PDF, EPUB y DOCX
- Gestión de usuarios y autenticación
- Interfaz intuitiva y responsive
- Previsualización de documentos
- Controles de zoom y navegación
- Búsqueda de texto en documentos
- Gestión de perfil de usuario

## Requisitos del Sistema

- PHP >= 8.1
- Composer
- Node.js y NPM
- MySQL >= 5.7
- Extensión PHP para PDF (php-pdf)
- Extensión PHP para ZIP (php-zip)

## Instalación

1. Clonar el repositorio:
```bash
git clone https://github.com/tu-usuario/visor-docs.git
cd visor-docs
```

2. Instalar dependencias de PHP:
```bash
composer install
```

3. Instalar dependencias de Node.js:
```bash
npm install
```

4. Copiar el archivo de entorno:
```bash
cp .env.example .env
```

5. Generar la clave de aplicación:
```bash
php artisan key:generate
```

6. Configurar la base de datos en el archivo `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=visor_docs
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

7. Ejecutar las migraciones:
```bash
php artisan migrate
```

8. Compilar los assets:
```bash
npm run build
```

9. Iniciar el servidor de desarrollo:
```bash
php artisan serve
```

## Estructura del Proyecto

```
visor-docs/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── DocumentoController.php
│   │   │   └── ProfileController.php
│   │   └── Requests/
│   ├── Models/
│   │   └── Documento.php
│   └── Services/
│       └── DocumentoService.php
├── config/
├── database/
│   └── migrations/
├── public/
│   └── images/
│       ├── pdf-preview.svg
│       ├── epub-preview.svg
│       └── docx-preview.svg
├── resources/
│   ├── js/
│   ├── css/
│   └── views/
│       └── documentos/
├── routes/
│   ├── web.php
│   └── api.php
└── tests/
```

## Uso

1. Acceder a la aplicación en `http://localhost:8000`
2. Registrarse o iniciar sesión
3. Subir documentos desde el botón "Nuevo Documento"
4. Visualizar documentos haciendo clic en "Leer"
5. Utilizar los controles de zoom y navegación en el visor

## Formatos Soportados

- PDF: Visualización nativa con controles de zoom y navegación
- EPUB: Visualización con soporte para navegación entre capítulos
- DOCX: Visualización con formato preservado

## Contribución

1. Fork el proyecto
2. Crear una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abrir un Pull Request

## Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo [LICENSE](LICENSE) para más detalles.

```text
MIT License

Copyright (c) 2024 Tu Nombre

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```

## Contacto

Tu Nombre - [@tutwitter](https://twitter.com/tutwitter) - email@ejemplo.com

Link del Proyecto: [https://github.com/tu-usuario/visor-docs](https://github.com/tu-usuario/visor-docs)
