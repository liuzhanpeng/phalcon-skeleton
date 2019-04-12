<?php
namespace App\Providers;

use Phalcon\Mvc\Router;

/**
 * 路由服务提供器
 */
class RouterProvider extends AbstractProvider
{
    public function register(\Phalcon\DiInterface $di)
    {
        $params = $this->params;
        $di->setShared($this->name, function () use ($params) {

            $router = new Router(false);
            $router->setEventsManager($this->get('eventsManager'));
            $router->setDefaultModule($params->get('defaultModule'));
            $router->setDefaultController($params->get('defaultController'));
            $router->setDefaultAction($params->get('defaultAction'));
            foreach ($params->routes as $k => $v) {
                $router->add($k, $v->toArray());
            }

            $router->add('/:module/:controller/:action/:params', [
                'module' => 1,
                'controller' => 2,
                'action' => 3,
                'params' => 4
            ]);

            return $router;
        });
    }
}