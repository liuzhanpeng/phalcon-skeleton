<?php
namespace App\Providers;

/**
 * 事件管理服务提供器
 * 为方便各个服务事件管理，统一使用一个事件管理器;
 */
class EventsManagerProvider extends AbstractProvider
{
    public function register(\Phalcon\DiInterface $di)
    {
        $di->setShared($this->name, function() {
            $eventsManager = new \Phalcon\Events\Manager();
            // 启用事件优先组
            $eventsManager->enablePriorities(true);

            return $eventsManager;
        });
    }
}