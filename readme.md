# SIMPLES API DE LIVROS

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/b4e2f043675e4aa7b4131714b45c3ced)](https://app.codacy.com/app/brunocaramelo/library_api?utm_source=github.com&utm_medium=referral&utm_content=brunocaramelo/library_api&utm_campaign=Badge_Grade_Settings)

[![Codacy Badge](https://api.codacy.com/project/badge/Coverage/0ee714429a0148b282e582025dcdd80e)](https://www.codacy.com/app/brunocaramelo/library_api?utm_source=github.com&utm_medium=referral&utm_content=brunocaramelo/library_api&utm_campaign=Badge_Coverage)

Aplicação simples de CRUD de Livros, Autores e Disciplinas utilizando técnicas que podem ser utilizadas com CI/CD
para gerencimento de ambientes com o uso de:


## Acessos:

Disponivel no Heroku com o seguinte Link:

http://api-library-testcase.herokuapp.com/api/documentation e coverage report em:

http://api-library-testcase.herokuapp.com/coverage-report


## Especificações Técnicas

Esta aplicação conta com as seguintes especificações abaixo: 

| Ferramenta | Versão |
| --- | --- |
| Docker | 1.13.1 |
| Docker Compose | 1.22.0 |
| Nginx | 1.15.2 |
| PHP | 7.2.11 |
| Mariabd | 10.3.8 |
| Redis | 5.0.0 |
| Sqlite | 3.16.2 |
| Laravel Framework | 5.7.* |
| Swagger | 2.*.* |

A aplicação é separada pelos seguintes conteineres

| Service | Image |
| --- | --- |
| mysql | mariadb:latest |
| redis | redis:alpine |
| php | laravel:php-fpm |
| web (nginx) | nginx:alpine |

## Requisitos
    - Docker
    - Docker Daemon (Service)
    - Docker Compose

## Procedimentos de Instalação
    Procedimentos de Instação da aplicação para uso local

1- Baixar repositório 
    - git clone https://github.com/brunocaramelo/library_api.git

2 - Verificar se as portas 80 e 3306 estão ocupadas.

3 - Entrar no diretório base da aplicação e executar os comandos abaixo:
    
    1 - sudo docker-compose up -d; (LER OBSERVACAO)

    2 - sudo docker exec -t php-library php /var/www/html/artisan migrate;

    3 - sudo docker exec -t php-library php /var/www/html/artisan db:seed;

    4 - sudo docker exec -t php-library php /var/www/html/artisan key:generate;
    
    5 - sudo docker exec -t php-library phpunit;

    
### Descrição dos Passos

    1 -  para que as imagens sejam armazenandas e executadas e subir as instancias
        
        (OBSERVACAO) - devido a demora do composer em trazer as dependências, existem 3 alternativas,
        
            1 - EXECUTAR sudo docker-compose up; sem ser daemon a primeira vez, para que seja possivel verificar o andamento da instalação de dependências.
            
            2 - Aguardar uns 20 minutos ou pouco mais para que o comando seja efetivado. afim de evitar de autoload por exemplo.
            
            3 - Caso tenha algum problema de Depencias, executar o comando abaixo para garantir as mesmas.
                sudo docker exec -t php-library composer install;
    
    2 -  para que o framework gere e aplique o mapeamento para a base de dados (SQL) podendo ser Mysql, PostGres , Oracle , SQL Serve ou SQLITE por exemplo
    
    3 -  para que o framework  aplique mudanças nos dados da base, no caso inserção de um primeiro usuário.
    
    4 -  geração de hash key para uso do sistema como chave de validação.
    
    5 - para que o framework execute a suite de testes.
        - testes de API  
        - testes de unidade
     
### Resolução de possíveis problemas:

#### Problemas com dependências/autoload (Passo 1)
    devido a demora do composer em trazer as dependências, existem 3 alternativas,
        
            1 - EXECUTAR sudo docker-compose up; sem ser daemon a primeira vez, para que seja possivel verificar o andamento da instalação de dependências.
            
            2 - Aguardar uns 20 minutos ou pouco mais para que o comando seja efetivado. afim de evitar erros de autoload por exemplo.
            
            3 - Caso tenha algum problema de Depencias, executar o comando abaixo para garantir as mesmas.
                sudo docker exec -t php-library composer install;

#### Problemas com permissão do Webserver ao volume exposto (Passo 6)
    - O mesmo pode ter problemas de permissão do Webserver ao volume /var/www/html (ou subdiretórios)
      Mesmo não sendo indicado, mas por ser um ambiente local, pode ser feita a execução forçada de permissões com:
       - sudo docker-compose exec web chmod 777 -R /var/www/html    

## Pós Instalação

Após instalar o endereço de acesso é:

- http://localhost/api/documentation


## Changelog

### v1.8.0
#### Coverage Full
 - Cobertura de testes 100%
 - Coverage também com a plataforma Codacy

### v1.7.0
#### Code Review
 - Refatoração de código
 - Service Providers
 - Lints

### v1.6.0
#### Release Estável
 - Ajustes de Readme.
 - Ajuste de orientação
 - Correção de pequenos bugs

### v1.5.0
#### Implantação no Heroku
- Correções de bugs
- Ajustes no read.me
- Ajustes no schema do Swagger
- Disponibilização da aplicação em : http://api-library-testcase.herokuapp.com/api/documentation

### v1.4.0
#### Instalação do Swagger e ajustes finais
- Ajustes em Books
- Instalação do Swagger
- Ajustes de CI/CD

### v1.3.0
#### Módulo de Livros
- Ajustes de Disciplinas e Autores
- Finalização da cobertura de testes
- Módulo de Livos

### v1.2.0
#### Módulos de Disciplina e Autores
- Adição de Módulos de Disciplinas e Autores
- Testes Unitários e de API
- Adicionado Coverage Report
- Seeder de teste
- API pública com módulos de Disciplina e Autores

### 1.1.0
#### Migrations e Seeders
- Estruturação do schema
- Execução da migração para a base de dados
- Criação e estruturação
- Execução dos Seeders com base no JSON exposto (storage/data_import/data-origin.json)

### v1.0.0
#### Framework e Deploy

- Framework Laravel 5.7
- Docker utilizando versão 1.13
- Docker compose versão 1.22
- Contexto de contêiners
    - PHP + PHP-FPM
    - Nginx
    - Mariadb
    - Redis

#### Executando PHPMetrics

    Ir para application
    
    php ./vendor/bin/phpmetrics --report-html=tests/_reports/phpmetrics app/ app/Domain
