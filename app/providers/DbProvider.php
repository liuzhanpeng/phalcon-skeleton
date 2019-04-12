<?php
namespace App\Providers;

/**
 * 数据库服务组件提供器
 */
class DbProvider extends AbstractProvider
{
    public function register(\Phalcon\DiInterface $di)
    {
        $params = $this->params;
        $di->setShared($this->name, function() use ($params) {
            $db = new \Phalcon\Db\Adapter\Pdo\Mysql($params->toArray());
            $db->setEventsManager($this->get('eventsManager'));

            return $db;
        });
    }
}