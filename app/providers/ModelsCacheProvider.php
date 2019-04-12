<?php
namespace App\Providers;

/**
 * 模型缓存服务提供器
 */
class ModelsCacheProvider extends AbstractProvider
{
    public function register(\Phalcon\DiInterface $di)
    {
        $params = $this->params;
        $di->setShared($this->name, function () use($params) {
            $frontendCache = new \Phalcon\Cache\Frontend\Data([
                'lifetime' => $params->get('lifetime'),
            ]);

            $params['frontend'] = $frontendCache;
            $backendCache = \Phalcon\Cache\Backend\Factory::load($params->toArray());

            return $backendCache;
        });
    }
}
