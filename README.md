Install
------

* Composer install
    ```bash
    composer require nhuongph/exceptionlog
    ```
 
* Install service provider:

    ```php
    // config/app.php

    'providers' => [
        ...
        \NhuongPH\ExceptionLog\ExceptionLogServiceProvider::class,
        ...
    ];
    ``` 
    
* Run

    ```php
    php artisan composer dump-autoload
    php artisan vendor:publish