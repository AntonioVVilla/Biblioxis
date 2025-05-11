# BiblioXis

BiblioXis es una aplicación web para la gestión y visualización de documentos PDF y EPUB.

## Requisitos

- Docker (En windows instalamos docker desktop)
- Docker Compose
- Git
- NPM (En windows instalamos node.js version mínima la 18)

## Instalación con Docker

1. Clonar el repositorio:
```bash
git clone [URL_DEL_REPOSITORIO]
cd biblioxis
```

2. Configurar el entorno:
```bash
# Copiar el archivo de variables de entorno (es posible que requiera el uso del comando 'sudo' si no has includio tu usuario en el grupo Docker)
cp .env.docker .env

# Construir y ejecutar los contenedores (verifica que no hay otros contenedores de docker que usen puertos como el 3306 o el 8000)
docker-compose up -d --build
```

3. Configurar la aplicación:
```bash
# Ejecuta composer install
sudo docker-compose exec app composer install
 
# Generar la clave de aplicación
docker-compose exec app php artisan key:generate

# Ejecutar migraciones
docker-compose exec app php artisan migrate

# Instalar dependencias de npm en el directorio del proyecto (pendiente añadir npm al contendor para poder hacer docker-compose exec app)
npm install
npm run build

# Ajustes de permisos
sudo docker-compose exec app chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

```

4. Acceder a la aplicación:
- La aplicación estará disponible en: http://localhost:8000
- MySQL: puerto 3306
- Redis: puerto 6379

## Comandos Docker útiles

### Gestión de contenedores
```bash
# Iniciar todos los servicios
docker-compose up -d

# Detener todos los servicios
docker-compose down

# Reiniciar un servicio específico
docker-compose restart [servicio]  # Ejemplo: nginx, app, db, redis

# Ver logs en tiempo real
docker-compose logs -f [servicio]  # Opcional: especificar servicio
```

### Acceso a contenedores
```bash
# Acceder a la terminal del contenedor de la aplicación
docker-compose exec app bash

# Acceder a la terminal de MySQL
docker-compose exec db mysql -u biblioxis -p

# Acceder a Redis CLI
docker-compose exec redis redis-cli
```

### Mantenimiento de la aplicación
```bash
# Ejecutar migraciones
docker-compose exec app php artisan migrate

# Ejecutar seeders
docker-compose exec app php artisan db:seed

# Limpiar caché
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan view:clear

# Recompilar assets
docker-compose exec app npm run dev
docker-compose exec app npm run build
```

### Gestión de volúmenes
```bash
# Listar volúmenes
docker volume ls

# Eliminar volúmenes (cuidado: esto eliminará los datos)
docker-compose down -v
```

### Monitoreo
```bash
# Ver estado de los contenedores
docker-compose ps

# Ver uso de recursos
docker stats

# Ver logs específicos
docker-compose logs app  # Logs de la aplicación
docker-compose logs nginx  # Logs de Nginx
docker-compose logs db  # Logs de MySQL
```

## Estructura del proyecto

```
biblioxis/
├── app/              # Código fuente de la aplicación
├── bootstrap/        # Archivos de arranque
├── config/          # Configuraciones
├── database/        # Migraciones y seeders
├── docker/          # Configuraciones de Docker
│   └── nginx/       # Configuración de Nginx
├── public/          # Archivos públicos
├── resources/       # Vistas y assets
├── routes/          # Rutas de la aplicación
├── storage/         # Archivos de almacenamiento
├── tests/           # Pruebas
├── .env.docker      # Variables de entorno para Docker
├── docker-compose.yml # Configuración de servicios
├── Dockerfile       # Configuración del contenedor PHP
└── README.md        # Este archivo
```

## Solución de problemas comunes

1. **Error de permisos**:
```bash
docker-compose exec app chown -R www-data:www-data storage bootstrap/cache
```

2. **Reconstruir contenedores**:
```bash
docker-compose down
docker-compose up -d --build
```

3. **Limpiar caché de Docker**:
```bash
docker system prune -a
```

4. **Verificar conexión a la base de datos**:
```bash
docker-compose exec db mysql -u biblioxis -p -e "SHOW DATABASES;"
```
