<?php
namespace App\Core;

use App\Core\ConfigParser;
use Phalcon\Mvc\Model;

/**
 * 应用程序
 * @author zhanpeng liu <liuzhanpeng@gmail.com>
 */
class Application extends \Phalcon\Mvc\Application
{
    /**
     * 配置对象
     * @var \Phalcon\Config
     */
    protected $config;

    /**
     * 构造函数
     * @param array $config 应用程序配置
     */
    public function __construct(array $config)
    {
        $this->registerAutoloaders();
        
        // 配置数组自定义字符处理
        $this->config = (new ConfigParser($config))->getConfig();

        if ($this->config->get('debug')) {
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        } else {
            error_reporting(0);
            ini_set('display_errors', 0);
        }
        ini_set('data.timezone', $this->config->get('timezone'));
    }

    /**
     * 注册自动加载类
     */
    protected function registerAutoloaders()
    {
        // composer autoload
        require APP_PATH . '/../vendor/autoload.php';

        $loader = new \Phalcon\Loader();
        // 约定优于配置，只注册根命名空间
        $loader->registerNamespaces([
            'App' => APP_PATH,
        ]);
        $loader->register();
    }

    /**
     * 注册服务组件
     */
    protected function registerServices()
    {
        // 为简化，直接用Phalcon\Di\FactoryDefault
        $di = new \Phalcon\Di\FactoryDefault();
        // 将配置注册为服务，方便其它服务组件使用
        $di->setShared('config', $this->config);

        // 根据配置注册应用服务
        // 通过provider机制注册服务
        foreach ($this->config->get('services') as $name => $provider) {
            if (is_string($provider)) {
                (new $provider($name))->register($di);
            } else {
                $className = $provider->get('className');
                $params    = $provider->get('params');
                (new $className($name, $params))->register($di);
            }
        }

        // 附加监听器
        $eventsManager = $di->get('eventsManager');
        foreach ($this->config->get('listeners') as $name => $listeners) {
            foreach ($listeners as $listener) {
                $className = $listener->$listener->get('className');
                $params    = $listener->get('params');
                $priority  = $listener->get('priority', 100);
                $eventsManager->attach($name, new $className($params), $priority);
            }
        }
        $di->setShared('eventsManager', $eventsManager);

        $this->setDI($di);
    }

    /**
     * 运行应用
     */
    public function run()
    {
        Model::setup([
            'notNullValidations' => false,
            'columnRenaming'     => false,
        ]);

        $this->registerServices();

        // 注册模块
        $modules = [];
        foreach (array_keys($this->config->get('modules')->toArray()) as $name) {
            $modules[$name] = [
                'className' => \App\Core\Module::class,
                'path'      => APP_PATH . '/core/Module.php',
            ];
        }
        $this->registerModules($modules);

        // 取消自动渲染视频图
        $this->useImplicitView(false);

        try {
            $this->handle()->send();
        } catch (\Exception $ex) {
            if(!$this->config->get('debug')) {
                exit('error!');
            }
            throw $ex;
        }
    }
}