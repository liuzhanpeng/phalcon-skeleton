<?php
namespace App\Providers;

/**
 * 注释服务提供器
 */
class AnnotationsProvider extends AbstractProvider
{
    public function register(\Phalcon\DiInterface $di)
    {
        $params = $this->params;
        $di->setShared($this->name, function () use ($params) {
            $annotations = \Phalcon\Annotations\Factory::load($params->toArray());

            return $annotations;
        });
    }
}
