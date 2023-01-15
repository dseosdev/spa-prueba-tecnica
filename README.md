# Spa Prueba técnica

## Puesta en marcha del proyecto

### Clonar el proyecto
1. Clonar el proyecto: 

``` code

`git clone git@github.com:dseosdev/spa-prueba-tecnica.git`

```
2. Entrar en el directorio: 
``` code

`cd spa-prueba-tecnica`

```


### Levantar los contenedores de docker
``` code

docker-compose up --build

```

### Entrar en el contenedor de php
``` code

docker exec -ti php-spa bash

```

### Instalación de dependencias
``` code

composer update

```

### Lanzar migraciones
``` code

php bin/console doctrine:migrations:migrate

```

### Cargar datos de prueba
``` code

php bin/console doctrine:fixtures:load


```

### Crear base de datos de testing
``` code

php bin/console --env=test doctrine:database:create


```

## Testing

En cada prueba se regenera la DB y se cargan los datos de prueba

### Lanzar batería de tests
``` code

vendor/bin/phpunit

```

### Cobertura de tests
1. Test funcionales de todos los casos de uso
2. Test para respuestas correctas y tests para respuestas con errores (Por ejemplo email no valido, nombre de cliente vacío o servicio no disponible...)
3. En todos los tests se comprueba que se devuelve un JSON, con datos de respuesta exactos esperados y un HTTP Header (200 Success, 400 Bad Request)
4. Todos los tests extienden de un TestBase




# API

## Listado de servicios

### Méthod
GET

### EndPoint
/api/v1/spa-services/{locale}

### Ejemplos
http://0.0.0.0:8060/api/v1/spa-services

http://0.0.0.0:8060/api/v1/spa-services/en

http://0.0.0.0:8060/api/v1/spa-services/de

http://0.0.0.0:8060/api/v1/spa-services&fr



## Disponibilidad de servicios

### Méthod
GET

### EndPoint
/api/v1/spa-service-availability/{ID Servicio Spa}/{fecha}

### Ejemplos
http://0.0.0.0:8060/api/v1/spa-service-availability/1/2023-01-01

http://0.0.0.0:8060/api/v1/spa-service-availability/2/2023-01-01

http://0.0.0.0:8060/api/v1/spa-service-availability/3/2023-01-01

http://0.0.0.0:8060/api/v1/spa-service-availability/1/2023-01-02

http://0.0.0.0:8060/api/v1/spa-service-availability/2/2023-01-02

http://0.0.0.0:8060/api/v1/spa-service-availability/3/2023-01-02


## Crear una reserva

### Méthod
POST

### EndPoint
/api/v1/create-booking

### Estructura Json (Enviado en Body > Raw > Json)
{
    "customer_name": "{Nombre del cliente}",
    "customer_email": "{Email del cliente}",
    "day": "{Fecha del servicio reservado}",
    "hour": "{Hora del servicio reservado}",
    "spa_service": "{ID del servicio reservado}"
}

### Ejemplo
http://0.0.0.0:8060/api/v1/create-booking

#### Body
{
    "customer_name": "Juan Gonzalez",
    "customer_email": "juan.gonzalez@demo.com",
    "day": "2023-01-02",
    "hour": "14:00",
    "spa_service": "1"
}








