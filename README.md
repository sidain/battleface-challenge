Battleface Challenge
6-17-2021

Tech stack,
Php, Laravel, JWT-auth,SQLite

This challenge was done with Laravel, 
the database used was SQLite for simplicity( your php will need the extensions).

The command "php artisan serve" should be enough to run it

main modified files:
app\Models\AgeLoad.php
app\Models\Currency.php
app\Models\Quotation.php

app\Https\Controllers\AuthController.php    -- controller used to authenticate user and issue jwt token
app\Https\Controllers\QuotationController.php    -- controller used create quotes, calculate the total, and return the values


app\database\migrations\2021_06_18_071359_create_quotations_table.php -- creation of database quotation table
app\database\migrations\2021_06_18_071517_create_age_loads_table.php -- creation of database age load table
app\database\migrations\2021_06_18_071536_create_currencies_table.php -- creation of database age load table

app\resources\views\challenge.blade.php -- blade file, main html interface, utilizing simple vue and bootstrap frameworks
