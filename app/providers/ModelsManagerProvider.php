<?php
namespace App\Providers;

/**
 * 模型管理服务提供器
 */
class ModelsManagerProvider extends AbstractProvider
{
    public function register(\Phalcon\DiInterface $di)
    {
        $params = $this->params;
        $di ->setShared($this->name, function () use ($params) {
            $manager = new \Phalcon\Mvc\Model\Manager();
            $manager->setEventsManager($this->get('eventsManager'));

            return $manager;
        });
    }
}
