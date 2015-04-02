<?php

/*
 * Murilo Amaral (http://muriloamaral.com)
 * Édipo Rebouças (http://edipo.com.br).
 *
 * @link https://github.com/muriloacs/Middleware
 *
 * @copyright Copyright (c) 2015 Murilo Amaral
 * @license The MIT License (MIT)
 *
 * @since File available since Release 1.0
 */

return array(
    'Middleware\Module'
        => __DIR__.'/Module.php',
    'Middleware\Listener\MiddlewareListener'
        => __DIR__.'/src/Middleware/Listener/MiddlewareListener.php',
    'Middleware\Service\Factory\MiddlewareAbstractServiceFactory'
        => __DIR__.'/src/Middleware/Service/Factory/MiddlewareAbstractServiceFactory.php',
    'Middleware\Service\Factory\MiddlewareServiceFactory'
        => __DIR__.'/src/Middleware/Service/Factory/MiddlewareServiceFactory.php',
    'Middleware\Service\MiddlewareService'
        => __DIR__.'/src/Middleware/Service/MiddlewareService.php',
    'Middleware\MiddlewareInterface'
        => __DIR__.'/src/Middleware/MiddlewareInterface.php'
);
