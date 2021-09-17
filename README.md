<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>


## BackendApi Test (GLADE)

This is a laravel application that takes into account user roles for certain operations to be carried out. User can create Admin, Company and Employes as well as perform other functions on these resources.

Tools Used:

- Laravel Framework => ^7.29
- Laravel tymon/jwt-auth=> "^1.0. (For Authentication)
- Php => 7.4.15).

I made use of Requests, Resources, Tests, Interface and services.

## Testing and Validation

Validation will check that the matrices follow the principle of A matrix columns equaling B matrix rows. If this validation fails an error is returned

Testing will ensure the code is written to accomodate scenarios such as a matrix of unequal columns or rows. As well as input with alphanumeric characters as all input values should be numeric.

## Setup

- Clone repo
- Run composer intall/update
- copy .env.example to .env
- Run Php artisan key:generate
- Run Php Artisan jwt:secret
- Run Php Artisan migrate.
- Run Php Artisan db:seed.
- Run Php Artisan storage:link.
## Test Setup
- Run <b>php artisan config:cache</b>
- Run <b>php artisan config:clear</b>
- TO RUN TESTS USE 'composer test' or (vendor/bin/phpunit)


## API Documentation
This application at the time of this writing has some  endpoints for authentication and for performing CRUD Operations on Employee and Company Resources'. To view the parameter requirements and expected return values, check out the API documentation from the postman documenter url below.<br>
**[Api Documentation Url ](https://documenter.getpostman.com/view/7533984/U16qJ2u4)**


