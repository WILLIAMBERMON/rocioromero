<?php

namespace Config;

use CodeIgniter\Database\Config;

/**
 * Database Configuration
 */
class Database extends Config
{
    /**
     * The directory that holds the Migrations
     * and Seeds directories.
     */
    public string $filesPath = APPPATH . 'Database' . DIRECTORY_SEPARATOR;

    /**
     * Lets you choose which connection group to
     * use if no other is specified.
     */
    public string $defaultGroup = 'default';

    /**
     * The default database connection.
     */
    public array 
    $default = [
       'DSN'      => 'MySQLi:host=ingserver.online;port=3306;dbname=ingserver2026_rocio;user=ingserver2026_rociouser;password=USER2026*',
        'hostname' => 'ingserver.online',
		'username' => 'ingserver2026_rociouser',
        'password' => 'USER2026*',
		'database' => 'ingserver2026_rocio',
        'DBDriver' => 'MySQLi',
        'DBPrefix' => '',
        'pConnect' => false,
        'DBDebug'  => (ENVIRONMENT !== 'production'),
        'charset'  => 'utf8',
        'DBCollat' => 'utf8_general_ci',
        'swapPre'  => '',
        'encrypt'  => false,
        'compress' => false,
        'strictOn' => false,
        'failover' => [],
        'port'     => 3306,
    ];
    /*$default = [
       'DSN'      => 'pgsql:host=192.168.13.251;port=5432;dbname=postgres;user=postgres;password=mysecretpassword',
        'hostname' => '192.168.13.251',
		'username' => 'postgres',
        'password' => 'mysecretpassword',
		'database' => 'postgres',
        'DBDriver' => 'postgre',
        'DBPrefix' => '',
        'pConnect' => false,
        'DBDebug'  => (ENVIRONMENT !== 'production'),
        'charset'  => 'utf8',
        'DBCollat' => 'utf8_general_ci',
        'swapPre'  => '',
        'encrypt'  => false,
        'compress' => false,
        'strictOn' => false,
        'failover' => [],
        'port'     => 5432,
    ];*/
    /*
    Usuario: ingserver2026_rociouser
    Clave: USER2026*
    Base de datos: ingserver2026_rocio
    

*/
    public function __construct()
    {
        parent::__construct();

        // Ensure that we always set the database group to 'tests' if
        // we are currently running an automated test suite, so that
        // we don't overwrite live data on accident.
        if (ENVIRONMENT === 'testing') {
            $this->defaultGroup = 'tests';
        }
    }
}
