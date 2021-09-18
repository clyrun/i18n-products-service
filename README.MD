# Products i18n Service
*Docker configuration intended for development environment use only* 😊

## Installation

Clone the repository

    git clone https://github.com/clyrun/i18n-products-service.git

Switch to the repository installation folder

    cd ~ /path/to/repository

Install Dependencies

    cd ~ service-products/src
    composer install --ignore-platform-reqs

Configure the database connection (Username & Password) in the following files:

    /path/to/repository/service-products/src/.env
    /path/to/repository/mysql.config.env
    
Run the docker-compose from the repository base installation folder

    cd ~ /path/to/repository
    docker-compose up

Find the **service-products** container name in another terminal:

    docker ps -a
    
Connect to the **service-products** container:

    docker exec -it <service-products-container-name> bash
    eg: docker exec -it code_service-products_1 bash
    
Run the Migration & Seed scripts for the Database from the service-products container:

    php artisan migrate
    php artisan db:seed

Test the API:

    http://127.0.0.1/api/en-gb/product/1

## Other
Tests can be executed from the service-products container:

    docker exec -it <service-products-container-name> bash
    ./vendor/phpunit/phpunit/phpunit

Example **UPDATE JSON** Request

    {
        "price": 10.52,
        "localization":
        {
            "locale":"en-gb",
            "product_name":"New Product Name",
            "product_desc":"New Product Description",
            "product_category": "New Category"
        }
    }
