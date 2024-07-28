# SIMPLE API OF BOOKS

Simple application of CRUD of Books, Authors and Disciplines using techniques that can be used with CI/CD
for managing environments with the use of:


## Technical Specifications

This application has the following specifications: 

| Tool | Version |
| --- | --- |
| Docker | 24.0.7 |
| Docker Compose | 1.29.2 |
| Nginx | 1.19.2 |
| PHP | 8.3.9 |
| Mariabd | 10.11.3 |
| Redis | 5.0.0 |
| Sqlite | 3.16.2 |
| Laravel Framework | 11.14.* |
| Swagger | 2.*.* |
| Rabbitmq | 3.*.* |

The application is separated by the following containers

| Service | Image | Motivação
| --- | --- | --- |
| mysql | mariadb:latest | Default database |
| redis | redis:alpine | Cache provider |
| php | laravel:php-fpm | Web Application backend |
| worker-queue | laravel:php-fpm | Scheduler |
| worker-php | laravel:php-fpm | Queue processor |
| web (nginx) | nginx:alpine | Web Server |
| rabbitmq | rabbitmq:3-management-alpine | Queues |

## Requirements
    - Docker
    - Docker Daemon (Service)
    - Docker Compose

## Installation Procedures
    Application Installation Procedures for Local Use

1- Download repository 
    
2 - Check if doors 80 and 3306 are occupied.

3 - Enter the base directory of the application and execute the commands below:
    
    0 - cp docker/docker-compose-env/database.env.example docker/docker-compose-env/database.env
        - cp docker/docker-compose-env/application.env.example docker/docker-compose-env/application.env
        - cp docker/docker-compose-env/messagequeue.env.example docker/docker-compose-env/messagequeue.env

    1 - docker-compose up -d; (READ OBSERVATION)

    2 - docker exec -t php-library-example php /app/artisan migrate;

    3 - docker exec -t php-library-example php /app/artisan db:seed;

    4 - docker exec -t php-library-example php /app/artisan key:generate;
    

    
#### Description of the Steps

    1 - for the images to be stored and executed and to upload the instances
        
        (OBSERVATION) - due to the delay of the composer in bringing the dependencies, there are 3 alternatives,
        
            1 - EXECUTE sudo docker-compose up; without being daemon the first time, so that it is possible to check the progress of the installation of dependencies.
            
            2 - Wait about 20 minutes or a little more for the command to be effective. in order to avoid autoload for example.
            
            3 - In case you have any problem of Dependencies, execute the command below to guarantee them.
                sudo docker exec -t php-library-example composer install;
    
    2 - so that the framework manages and applies the mapping to the database (SQL) can be Mysql, PostGres , Oracle , SQL Serve or SQLITE for example
    
    3 - for the framework to apply changes to the database data, in the case of a first user insertion.
    
    4 - generation of hash key to use the system as validation key.
    
    5 - for the framework to execute the test suite.
        - API tests  
        - unit tests
     
### Resolution of possible problems:

#### Problems with dependencies/autoload (Step 1)
    Due to the delay of the composer in bringing the dependencies, there are 3 alternatives,
        
            1 - EXECUTE sudo docker-compose up; without being daemon the first time, so that it is possible to check the progress of the installation of dependencies.
            
            2 - Wait about 20 minutes or a little more for the command to be effective. in order to avoid autoload errors for example.
            
            3 - In case you have any problem with dependencies, execute the command below to guarantee them.
                sudo docker exec -t php-library-example composer install;

#### Problems with Webserver permission to the exposed volume (Step 6)
    - The same may have webserver permission problems at volume /app (or subdirectories)
      Even though it is not indicated, but because it is a local environment, the forced execution of permissions can be done with:
       - sudo docker-compose exec web chmod 777 -R /app    

## Post Installation

After installing the access address is:

- https://localhost/api/documentation


## Changelog

### v1.7.0
#### Code Review
 - Code Refactoring
 - Service Providers
 - Lints

### v1.6.0
#### Stable Release
 - Readme adjustments.
 - Orientation Adjustment
 - Small bug fixes


### v1.4.0
#### Swagger installation and final adjustments
- Adjustments in Books
- Swagger Installation
- IC/CD adjustments

### v1.3.0
#### Book Module
- Adjustments of Disciplines and Authors
- Completion of test coverage
- File Module

### v1.2.0
#### Discipline Modules and Authors
- Addition of Discipline Modules and Authors
- Unitary and API Testing
- Added Coverage Report
- Test Seeder
- Public API with Discipline modules and Authors

### 1.1.0
#### Migrations and Seeders
- Schema structuring
- Execution of the migration to the database
- Creation and structuring
- Seeders execution based on the JSON exposed (storage/data_import/data-origin.json)


### v1.0.0
#### Framework and Deploy

- Laravel Framework 5.7
- Docker using version 1.13
- Docker compose version 1.22
- Container Context
    - PHP + PHP-FPM
    - Nginx
    - Mariadb
    - Redis

#### Running PHPMetrics

    Go to application
    
    sudo docker exec -t php-library-example php ./vendor/bin/phpmetrics --report-html=tests/_reports/phpmetrics app/ app/Domain