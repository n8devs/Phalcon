<?php

/**
 * Registering an autoloader
 */
$loader = new \Phalcon\Loader();

// Register directories
$loader->registerDirs(
    [
        $config->application->modelsDir,
        $config->application->vendorDir . 'never8/data'
    ]
)
    ->registerNamespaces(
        [
            'Phalcon' => APP_PATH . '/library/Phalcon'
        ]
    )
    ->register();

//// Register namespaces
//$loader->registerNamespaces(
//    [
//       'Never8\Data' => $config->application->vendorDir . 'never8/data',
//    ]
//)->register();
