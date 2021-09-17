

## BackendApi Test (GLADE)

This is a laravel application that takes into account user roles for certain operations to be carried out. User can create Admin, Company and Employes as well as perform other functions on these resources.

Tools Used:

- Laravel Framework => ^7.29
- Laravel tymon/jwt-auth=> "^1.0. (For Authentication)
- Php => 7.4.15).

I made use of Requests, Resources, Tests, Interface and services.

## Testing and Validation

Validation will ensure that only authenticated users can use the api and  that only authorized users can carry out certain operations.

Testing will ensure the code is written to accomodate scenarios and that the code can be writen to satisfy these test and remain functional.

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

##Scope
-  Ability to create admin user accounts. The only permission this account type will have is
to create companies and employees. Nothing else.
- Use database seeds to create first user with email superadmin@admin.com and
password “password”
- CRUD functionality (Create / Read / Update / Delete) for two menu items: Companies
and Employees.
- Companies DB table consists of these fields: Name (required), email, logo (minimum
100×100), website
- Employees DB table consists of these fields: First name (required), last name (required),
Company (foreign key to Companies), email, phone
- Use database migrations to create those schemas above
- Store companies logos in storage/app/public folder and make them accessible from
public
- Use Laravel’s validation function, using Request classes
- A company account should be able to login and view all their employees
- An employee should be able to login and view their company’s details
- Company can create employee account
- Admin can create employee and company account
- Super admin can create and delete admin, company, employee accounts.
- Superadmin and admin account should be able to see all companies and employees
- Superadmin account should be able to see which admin created a company. Like an
audit trail.
- Use Laravel’s pagination for showing Companies/Employees list, 10 entries per page
- Email notification: send email whenever new company is entered (use Mailgun or
Mailtrap)
- Roles this application will have are superadmin, admin, company and employee.


