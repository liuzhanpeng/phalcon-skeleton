<?php
namespace App\Listeners;

use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Config;

/**
 * 监听404
 * @author zhanpeng liu <liuzhanpeng@gmail.com>
 */
class NotFoundActionListener
{
    /**
     * 构造函数
     * @param Phalcon\Config $params 参数
     */
    public function __construct(?Config $params)
    {
    }

    public function beforeNotFoundAction(Event $event, Dispatcher $dispatcher)
    {
        exit('404');
    }
}
