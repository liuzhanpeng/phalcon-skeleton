<?php
namespace App\Core;

use Phalcon\DiInterface;

/**
 * 模块类
 * @author zhanpeng liu <liuzhanpeng@gmail.com>
 */
class Module implements \Phalcon\Mvc\ModuleDefinitionInterface
{
    public function registerAutoloaders(DiInterface $di = null)
    {
        // $moduleName = $di->get('router')->getModuleName();

        // $loader = new \Phalcon\Loader();
        // $loader->registerNamespaces([
        //     'App\\Modules\\' . ucfirst($moduleName) => APP_PATH . '/modules/' . $moduleName . '/',
        // ]);
        // $loader->register();
    }

    public function registerServices(DiInterface $di)
    {
        $moduleName = $di->get('router')->getModuleName();
        $config = $di->get('config')->get('modules');
        if ($config->get($moduleName) == null) {
            throw new \Exception('找不到模块"' . $moduleName . '"配置');
        }

        $moduleConfig = $config->get($moduleName);

        // 注册模块服务
        if ($moduleConfig->get('services') != null) {
            foreach ($moduleConfig->get('services') as $name => $provider) {
                if (is_string($provider)) {
                    (new $provider($name))->register($di);
                } else {
                    $className = $provider->get('className');
                    $params    = $provider->get('params', []);
                    (new $className($name, $params))->register($di);
                }
            }
        }

        // 附加模块监听器
        if ($moduleConfig->get('listeners') != null) {
            $eventsManager = $di->get('eventsManager');
            foreach ($moduleConfig->get('listeners') as $name => $listeners) {
                foreach ($listeners as $listener) {
                    $className = $listener->get('className');
                    $params    = $listener->get('params', []);
                    $priority  = $listener->get('priority', 100);
                    $eventsManager->attach($name, new $className($params), $priority);
                }
            }
            $di->setShared('eventsManager', $eventsManager);
        }
    }
}