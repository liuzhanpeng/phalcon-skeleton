<?php
namespace App\Providers;

/**
 * 请求分发服务提供器
 */
class DispatcherProvider extends AbstractProvider
{
    public function register(\Phalcon\DiInterface $di)
    {
        $di->setShared($this->name, function() {
            $moduleName = ucfirst($this->get('router')->getModuleName());
            $controllerNamesapce = "\\App\\Modules\\$moduleName\\Controllers";
            
            $dispatcher = new \Phalcon\Mvc\Dispatcher();
            $dispatcher->setEventsManager($this->get('eventsManager'));
            $dispatcher->setDefaultNamespace($controllerNamesapce);

            return $dispatcher;
        });
    }
}