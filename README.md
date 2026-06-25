## Instalación del proyecto

1. Instalar dependencias:
```bash
$ composer install
```

2. Crear base de datos
```bash
$ docker-compose up -d
```

3. Renombrar el archivo ```.env.example ``` a ```.env```

4. Crear la base de datos:
```bash
php artisan migrate
```
5. Crear Usuario Filament
```bash
php artisan make:filament-user
```

