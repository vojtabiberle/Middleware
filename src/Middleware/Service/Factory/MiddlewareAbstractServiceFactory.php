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

namespace Middleware\Service\Factory;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MiddlewareAbstractServiceFactory implements AbstractFactoryInterface
{
    /**
     * Determine if we can create a service with name.
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param string $name
     * @param string $requestedName
     *
     * @return bool
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        $interfaces = class_implements($requestedName);

        if (is_array($interfaces)) {
            return isset($interfaces['Middleware\MiddlewareInterface']);
        }

        return false;
    }

    /**
     * Create service with name.
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param string $name
     * @param string $requestedName
     *
     * @return \Middleware\MiddlewareInterface
     */
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        return new $requestedName();
    }
}
