<?php

/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return [
    'db' => [
        'driver' => 'Pdo',
        'dsn' => sprintf('sqlite:%s/data/laminastutorial.db', realpath(getcwd())),
    ]
];

/**
 * If you were configuring a database that required credentials, you would put the general configuration in your config/autoload/global.php, and then the configuration for the current environment, including the DSN and credentials, in the config/autoload/local.php file. These get merged when the application runs, ensuring you have a full definition, but allows you to keep files with credentials outside of version control.
 */