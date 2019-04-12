<?php
namespace App\Providers;

/**
 * 加密服务提供器
 */
class CryptProvider extends AbstractProvider
{
    public function register(\Phalcon\DiInterface $di)
    {
        $params = $this->params;
        $di->setShared($this->name, function () use ($params) {

            $crypt = new \Phalcon\Crypt();
            $crypt->setKey($params->get('cryptKey'));

            return $crypt;
        });
    }
}
