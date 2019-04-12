<?php
namespace App\Providers;

use Phalcon\Di\ServiceProviderInterface;
use Phalcon\DiInterface;

/**
 * 服务提供器抽象类
 * @author zhanpeng liu <liuzhanpeng@gmail.com>
 */
abstract class AbstractProvider implements ServiceProviderInterface
{
    /**
     * 服务名称
     * @var string
     */
    protected $name;

    /**
     * 参数
     * @var \Phalcon\Config
     */
    protected $params;

    /**
     * 构造函数
     * @param string $name 服务名称
     * @param array $params 参数
     */
    public function __construct(string $name, \Phalcon\Config $params = null)
    {
        $this->name = $name;
        $this->params = $params;
    }

    /**
     * 注册服务到di容器
     * @param DiInterface $di DI容器
     */
    abstract public function register(DiInterface $di);
}