<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => 'main',//env('DB_CONNECTION', 'pgsql'),
    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [
        'main' => [
            'driver' => 'pgsql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'public',
            'sslmode' => 'prefer',
        ],

        'information_pgsql' => [
            'driver' => 'pgsql',
            'url' => env('DATABASE_INFORMATION_URL'),
            'host' => env('DB_INFORMATION_HOST', '127.0.0.1'),
            'port' => env('DB_INFORMATION_PORT', '5432'),
            'database' => env('DB_INFORMATION_DATABASE', 'forge'),
            'username' => env('DB_INFORMATION_USERNAME', 'forge'),
            'password' => env('DB_INFORMATION_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'public',
            'sslmode' => 'prefer',
        ],

        'gifts_pgsql' => [
            'driver' => 'pgsql',
            'url' => env('DATABASE_GIFTS_URL'),
            'host' => env('DB_GIFTS_HOST', '127.0.0.1'),
            'port' => env('DB_GIFTS_PORT', '5432'),
            'database' => env('DB_GIFTS_DATABASE', 'forge'),
            'username' => env('DB_GIFTS_USERNAME', 'forge'),
            'password' => env('DB_GIFTS_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'public',
            'sslmode' => 'prefer',
        ],

        'levels_pgsql' => [
            'driver' => 'pgsql',
            'url' => env('DATABASE_LEVELS_URL'),
            'host' => env('DB_LEVELS_HOST', '127.0.0.1'),
            'port' => env('DB_LEVELS_PORT', '5432'),
            'database' => env('DB_LEVELS_DATABASE', 'forge'),
            'username' => env('DB_LEVELS_USERNAME', 'forge'),
            'password' => env('DB_LEVELS_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'public',
            'sslmode' => 'prefer',
        ],

        'users_pgsql' => [
            'driver' => 'pgsql',
            'url' => env('DB_USERS_URL'),
            'host' => env('DB_USERS_HOST', '127.0.0.1'),
            'port' => env('DB_USERS_PORT', '5432'),
            'database' => env('DB_USERS_DATABASE', 'forge'),
            'username' => env('DB_USERS_USERNAME', 'forge'),
            'password' => env('DB_USERS_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'public',
            'sslmode' => 'prefer',
        ],
        'activity_log_mongodb' => [
            'driver'   => 'mongodb',
            'host'     => env('ACTIVITY_LOG_DB_HOST', '127.0.0.1'),
            'port'     => env('ACTIVITY_LOG_DB_PORT', 27017),
            'database' => env('ACTIVITY_LOG_DB_DATABASE'),
            'username' => env('ACTIVITY_LOG_DB_USERNAME'),
            'password' => env('ACTIVITY_LOG_DB_PASSWORD'),
            'options'  => []
        ],
        'users_gifts_database' => [
            'driver'   => 'mongodb',
            'host'     => env('USERS_GIFTS_DB_HOST', '127.0.0.1'),
            'port'     => env('USERS_GIFTS_DB_PORT', 27017),
            'database' => env('USERS_GIFTS_DB_DATABASE'),
            'username' => env('USERS_GIFTS_DB_USERNAME'),
            'password' => env('USERS_GIFTS_DB_PASSWORD'),
            'options'  => []
        ],
        'levels_users_database' => [
            'driver'   => 'mongodb',
            'host'     => env('LEVELS_USERS_DB_HOST', '127.0.0.1'),
            'port'     => env('LEVELS_USERS_DB_PORT', 27017),
            'database' => env('LEVELS_USERS_DB_DATABASE'),
            'username' => env('LEVELS_USERS_DB_USERNAME'),
            'password' => env('LEVELS_USERS_DB_PASSWORD'),
            'options'  => []
        ],
        'transactions_database' => [
            'driver'   => 'mongodb',
            'host'     => env('TRANSACTIONS_DB_HOST', '127.0.0.1'),
            'port'     => env('TRANSACTIONS_DB_PORT', 27017),
            'database' => env('TRANSACTIONS_DB_DATABASE'),
            'username' => env('TRANSACTIONS_DB_USERNAME'),
            'password' => env('TRANSACTIONS_DB_PASSWORD'),
            'options'  => []
        ],
        'charges_database' => [
            'driver'   => 'mongodb',
            'host'     => env('CHARGES_DB_HOST', '127.0.0.1'),
            'port'     => env('CHARGES_DB_PORT', 27017),
            'database' => env('CHARGES_DB_DATABASE'),
            'username' => env('CHARGES_DB_USERNAME'),
            'password' => env('CHARGES_DB_PASSWORD'),
            'options'  => []
        ],
        'charges_premium_database' => [
            'driver'   => 'mongodb',
            'host'     => env('CHARGES_PREMIUM_DB_HOST', '127.0.0.1'),
            'port'     => env('CHARGES_PREMIUM_DB_PORT', 27017),
            'database' => env('CHARGES_PREMIUM_DB_DATABASE'),
            'username' => env('CHARGES_PREMIUM_DB_USERNAME'),
            'password' => env('CHARGES_PREMIUM_DB_PASSWORD'),
            'options'  => []
        ],


        'daily_charges_psql' => [
            'driver' => 'pgsql',
            'host' => env('DB_DAILY_CHARGES_HOST', '127.0.0.1'),
            'port' => env('DB_DAILY_CHARGES_PORT', 3306),
            'database' => env('DB_DAILY_CHARGES_DATABASE', 'forge'),
            'username' => env('DB_DAILY_CHARGES_USERNAME', 'forge'),
            'password' => env('DB_DAILY_CHARGES_PASSWORD', ''),
            'charset' => env('DB_CHARSET', 'utf8'),
            'prefix' => env('DB_PREFIX', ''),
            'schema' => env('DB_SCHEMA', 'public'),
            'sslmode' => env('DB_SSL_MODE', 'prefer'),
        ],
        'questionnaire_pgsql' => [
            'driver' => 'pgsql',
            'url' => env('DB_QUESTIONNAIRE_URL'),
            'host' => env('DB_QUESTIONNAIRE_HOST', '127.0.0.1'),
            'port' => env('DB_QUESTIONNAIRE_PORT', '5432'),
            'database' => env('DB_QUESTIONNAIRE_DATABASE', 'forge'),
            'username' => env('DB_QUESTIONNAIRE_USERNAME', 'forge'),
            'password' => env('DB_QUESTIONNAIRE_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'public',
            'sslmode' => 'prefer',
        ],

        'tg_users_pgsql' => [
            'driver' => 'pgsql',
            'url' => env('TG_USERS_DB_URL'),
            'host' => env('TG_USERS_DB_HOST', '127.0.0.1'),
            'port' => env('TG_USERS_DB_PORT', '5432'),
            'database' => env('TG_USERS_DB_DATABASE', 'forge'),
            'username' => env('TG_USERS_DB_USERNAME', 'forge'),
            'password' => env('TG_USERS_DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'public',
            'sslmode' => 'prefer',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer body of commands than a typical key-value system
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_database_'),
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
        ],

    ],

];
