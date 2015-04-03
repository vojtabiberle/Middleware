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

namespace Middleware\Listener;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;
use Middleware\Service\MiddlewareRunnerService as Service;

class MiddlewareListener extends AbstractListenerAggregate
{
    /**
     * @var array
     */
    protected $listeners = array();

    /**
     * Attachs onDispatch event.
     *
     * @param EventManagerInterface $eventManager
     */
    public function attach(EventManagerInterface $eventManager)
    {
        $this->listeners[] = $eventManager->attach(
            MvcEvent::EVENT_DISPATCH,
            array($this, 'onDispatch'),
            100
        );
    }

    /**
     * On dispatch handles local and global middlewares.
     *
     * @param MvcEvent $event
     */
    public function onDispatch(MvcEvent $event)
    {
        $sm = $event->getApplication()->getServiceManager();
        $service = $sm->get('MiddlewareRunnerService');
        $config  = $sm->get('Config');
        $controllerClass = $event->getRouteMatch()->getParam('controller').'Controller';

        $global = $config[Service::CONFIG][Service::CONFIG_GLOBAL];
        $local  = @$config[Service::CONFIG][Service::CONFIG_LOCAL][$controllerClass] ?: array();
        $middlewareNames = array_merge($global, $local);

        $service->run($middlewareNames);
    }
}
