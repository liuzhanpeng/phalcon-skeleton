<?php
namespace App\Providers;

/**
 * 用户服务提供器
 * @author zhanpeng liu <liuzhanpeng@gmail.com>
 */
class UserProvider extends AbstractProvider
{
    public function register(\Phalcon\DiInterface $di)
    {
        $params = $this->params;
        $di->setShared($this->name, function () use ($params) {
            $user = new \App\Components\Auth\User($params);

            return $user;
        });
    }
}
