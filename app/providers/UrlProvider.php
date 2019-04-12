<?php
namespace App\Providers;

/**
 * Url服务提供器
 * @author zhanpeng liu <liuzhanpeng@gmail.com>
 */
class UrlProvider extends AbstractProvider
{
    public function register(\Phalcon\DiInterface $di)
    {
        $di->setShared($this->name, function() {
            $url = new \Phalcon\Mvc\Url();
            $url->setBaseUri('/' . $this->get('router')->getModuleName() . '/');

            return $url;
        });
    }
}