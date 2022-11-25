### REQUIREMENT: Docker Desktop

## INSTRUCTIONS
1. Run `docker-compose up -d`
2. Run `docker ps`, copy CONTAINER ID of container named 'todo_app'
3. Run `docker exec -it <CONTAINER ID> sh`

### First time runnning only
4. Run `composer install`
5. Run `cp .env.example .env`
6. Run `php artisan migrate`

    If error encountered: Host 'x.x.x.x' is not allowed to connect to this MySQL server

    1. Run `exit` to leave container
    2. Get CONTAINER ID of 'todo_mysql', Run `docker exec -it <CONTAINER ID> sh`
    3. Run `mysql`
    4. Run `CREATE USER 'root'@'127.0.0.1' IDENTIFIED BY 'YzzYTr9yRkAZaq';GRANT ALL PRIVILEGES ON *.* TO 'root'@'127.0.0.1' WITH GRANT OPTION;CREATE USER 'root'@'%' IDENTIFIED BY 'YzzYTr9yRkAZaq';GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' WITH GRANT OPTION;`
    5. Run `exit` twice to return to main terminal
    6. Return to 'todo_app' docker container, Run `docker exec -it <CONTAINER ID> sh`
    7. Run `php artisan migrate`


### Start php development server
7. Run `php artisan serve --host=0.0.0.0`

Navigate to `http://localhost:8000`

### TESTING

1. Enter docker app container Run `docker exec -it <CONTAINER ID> sh`
2. Run `php artisan migrate --env=testing`
2. Run `php artisan test`