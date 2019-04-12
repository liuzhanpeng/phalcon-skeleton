<?php
namespace App\Providers;

/**
 * cookie服务提供器
 */
class CookiesProvider extends AbstractProvider
{
    public function register(\Phalcon\DiInterface $di)
    {
        $params = $this->params;
        $di->setShared($this->name, function () use ($params) {

            $cookies = new \Phalcon\Http\Response\Cookies();
            $cookies->useEncryption(true);
            $cookies->setExpiration($params->get('expire', 0));
            $cookies->setPath($params->get('path', '/'));
            $cookies->setDomain($params->get('domain', ''));
            $cookies->setSecure($params->get('secure', false));
            $cookies->setHttpOnly($params->get('httponly', ''));

            return $cookies;
        });
    }
}