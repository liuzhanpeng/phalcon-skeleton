<?php
namespace App\Providers;

/**
 * 会话服务组件提供器
 */
class SessionProvider extends AbstractProvider
{
    public function register(\Phalcon\DiInterface $di)
    {
        $params = $this->params;
        $di->setShared($this->name, function () use ($params) {

            $session = \Phalcon\Session\Factory::load($params->toArray());

            $session->start();

            return $session;
        });
    }
}
 