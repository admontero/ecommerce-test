# Ecommerce Test

API para la gestión de productos y órdenes.

## Instalación

Clonar el repositorio

    git clone https://github.com/admontero/ecommerce-test.git

Cambiar a la carpeta del repositorio

    cd ecommerce-test

Instalar las dependencias de PHP usando composer

    composer install

Copia el archivo ejemplo de variables de entorno y haz las configuraciones requeridas en tu archivo .env

    cp .env.example .env

Genera una key para la aplicación

    php artisan key:generate

------------

## Docker

Cambia las siguiente variables de entorno del .env:

    DB_CONNECTION=mysql
    DB_HOST=db
    DB_PORT=3306
    DB_DATABASE=laravel
    DB_USERNAME=root
    DB_PASSWORD=password

Ejecuta el siguiente comando para ejecutar la build:

    docker-compose build

Para ejecutar las migraciones y las semillas use el siguiente comando:

    docker exec ecommerce-test bash -c "php artisan migrate --seed"

Otros comandos importantes:

    docker-compose up (Ejecutar los servicios)
    docker-compose down (Detener los servicios)
    docker-compose restart (Reiniciar los servicios)
    docker-compose exec app bash (Entrar a la consola del contenedor)

## Documentación API

[Ecommerce API](https://documenter.getpostman.com/view/9609007/2sAY55bJVk)

## Autor

- [Andrés Montero](https://github.com/admontero)
