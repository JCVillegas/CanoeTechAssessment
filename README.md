## Canoe Tech Assessment for Remotely

### Tools used:
- Backend: Laravel 10 (PHP Framework)
- FrontEnd: Laravel Blade Engine (HTML,Javascript, CSS)
- RDMS: MYSQL 8.0

## Requirements
- [Docker desktop](https://www.docker.com/products/docker-desktop/)

## INSTALLATION
1. Clone this repo in your preferred directory:
```bash
git clone https://github.com/JCVillegas/CanoeTechAssessment.git
```
2. **cd** into the CanoeTechAssessment directory and copy the contents of the env.example file, into a new .env file:
```bash
cp .env.example .env
```
3. Inside the CanoeTechAssessment directory run composer:
```bash
composer install
```
4. Inside the CanoeTechAssessment directory run the DB migrations for the app and for the tests:
```bash
php artisan migrate
php artisan migrate --database=testing
```
5. Inside the CanoeTechAssessment directory  initiate the web server:
```bash
php artisan serve
```

8. Server will be running on: http://0.0.0.0:80


## Running tests
1. Inside the CanoeTechAssessment directory, go into the docker container:
```bash
docker exec -it canoetechassessment-laravel-1 /bin/bash
```

2. Run the tests:
```bash
php artisan test
```

