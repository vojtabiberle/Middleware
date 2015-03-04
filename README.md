Middleware
============

Creates middleware layer on Zend Framework 2. Useful when it's necessary to make some work between route and controller phases.


Installation
------------

#### With composer

1. Add this project in your composer.json:

    ```json
    "require": {
        "muriloamaral/Middleware": "dev-master"
    }
    ```


2. Now tell composer to download Middleware by running the command:

    ```bash
    $ php composer.phar update
    ```


#### Post installation

1. Enabling it in your `application.config.php` file.

    ```php
    return array(
        'modules' => array(
            // ...
            'Middleware',
        ),
        // ...
    );
    ```


Configuration
-------------

1. On your config file set your global and local middlewares. For instance:

    ```bash
    Application/config/module.config.php
    ```

    ```php
    'middlewares' => [
        'global' => [
            'my.first.middleware' => 'Application\Middleware\First'
        ],
        'local' => [
            'my.second.middleware' => 'Application\Middleware\Second'
        ]
    ],
    ```

2. Define your middleware classes:

    ```bash
    Application/Middleware/
    ```

    ```php
    namespace Application\Middleware;

    class First
    {
        public function handle($request, $next, $redirect)
        {
            var_dump($request->getHeader('user-agent'));
        }
    }
    ```

    ```php
    namespace Application\Middleware;

    class Second
    {
        public function handle($request, $next, $redirect)
        {
            if (true) {
                return $redirect('http://www.zendframework.com');
            }

            $next($request);
        }
    }
    ```


Usage
-----

#### Global scope
Middlewares on global scope will be used everytime a request is made.

#### Local scope
Middlewares on local scope will be used only if declared inside a controller. For instance:

    ```php
    namespace Application\Controller;

    use Zend\Mvc\Controller\AbstractActionController;

    class IndexController extends AbstractActionController
    {
        public static $middleware;

        public function __construct()
        {
            $middleware = self::$middleware;
            $middleware('my.second.middleware');
        }
    }
    ```

In this case, `my.first.middleware` will be always executed no matter what route is being called. Whereas `my.second.middleware` will be executed only when
Application\Controller\IndexController is called. Thus, if we access Application\Controller\IndexController both middlewares first and second will be executed.


Advanced usage
--------------

1. It's also possible to access ServiceManager within your middleware classes. It's only necessary to implement ServiceLocatorAwareInterface. For instance:

    ```php
    namespace Application\Middleware;

    use Zend\ServiceManager\ServiceLocatorAwareInterface;
    use Zend\ServiceManager\ServiceLocatorInterface;


    class First implements ServiceLocatorAwareInterface
    {
        protected $serviceLocator;

        public function handle($request, $next, $redirect)
        {
            $config = $this->serviceLocator->get('config');

            if ($config) {
                return $redirect('http://www.zendframework.com');
            }

            $next($request);
        }

        public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
        {
            $this->serviceLocator = $serviceLocator;
        }

        public function getServiceLocator()
        {
            return $this->serviceLocator;
        }
    }
    ```

2. An advisable approach is to implement MiddlewareInterface on your middleware classes. Just for the patterns...

    ```php
    namespace Application\Middleware;

    use Zend\Http\PhpEnvironment\Request;
    use Middleware\MiddlewareInterface;

    class First implements MiddlewareInterface
    {
        public function handle(Request $request, callable $next, callable $redirect)
        {

        }
    }
    ```