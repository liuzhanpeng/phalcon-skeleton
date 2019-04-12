<?php
namespace App\Providers;

/**
 * 模型元数据服务提供器
 */
class ModelsMetadataProvider extends AbstractProvider
{
    public function register(\Phalcon\DiInterface $di)
    {
        $params = $this->params;
        $di->setShared($this->name, function () use ($params) {
            $adapter = "\\Phalcon\\Mvc\\Model\\MetaData\\{$params['adapter']}";
            $metadata = new $adapter($params->toArray());

            return $metadata;
        });
    }
}
