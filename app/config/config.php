<?php
/*
 * Modified: prepend directory path of current file, because of this file own different ENV under between Apache and command line.
 * NOTE: please remove this comment.
 */
defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');

return new \Phalcon\Config([
    'database' => [
        'adapter'    => 'Mysql',
        'host'       => '127.0.0.1',
        'username'   => 'fda_mejorsucursalqa',
        'password'   => 'h4RFDw2EqVBEPdnT*',
        'dbname'     => 'fda_mejorsucursalqa',
        'charset'    => 'utf8',
    ],

    'application' => [
        'modelsDir'      => APP_PATH . '/models/',
        'migrationsDir'  => APP_PATH . '/migrations/',
        'viewsDir'       => APP_PATH . '/views/',
        'vendorDir'      => APP_PATH . '/vendor/',
        'baseUri'        => '/',
    ],

    'magecon' => [
        'api_base_url'=> 'http://qa.fahorro.com/rest/all/V1/',
        'api_access_token' => 'ohhi3swwr5x7vfxjzpkpmpnw93cunhlx'
    ],
    'mage_one_con'=>[],
    'api'=>[
        'access_token' => [
            'myEojOOZtzCY43nWWbNn8tRUBjDB0kA1',
            '9bPNmUdgOoOC3JuDApvuHw7L1QyYChY8',
            '6Va3caBIDwcxTNOOquMTCrbpIjPBaTuD'
        ]
    ]
]);
