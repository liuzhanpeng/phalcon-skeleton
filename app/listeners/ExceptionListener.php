<?php
namespace App\Listeners;

use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Config;

/**
 * 未处理异常监听器
 * 将异常信息记录到日志
 * @author zhanpeng liu <liuzhanpeng@gmail.com>
 */
class ExceptionListener
{
    /**
     * 日志文件路径
     * @var string
     */
    protected $logFile;
    
    /**
     * 构造函数
     * @param Phalcon\Config $params 参数
     */
    public function __construct(Config $params)
    {
        $this->logFile = $params->get('logFile');
    }

    public function beforeException(Event $event, Dispatcher $dispatcher, \Exception $exception)
    {
        $module = $dispatcher->getModuleName();
        $controller = $dispatcher->getControllerName();
        $action = $dispatcher->getActionName();

        $logger = new \Phalcon\Logger\Adapter\File($this->logFile);
        $logger->error('[' . $module . '/' . $controller . '/' . $action . '] ' . (string)$exception . PHP_EOL);
    }
}
