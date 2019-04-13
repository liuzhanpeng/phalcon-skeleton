<?php
namespace App\Modules\Admin\Listeners;

use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;

/**
 * 访问权限检查监听器
 * @author zhanpeng liu <liuzhanpeng@gmail.com>
 */
class AccessCheckListener extends \Phalcon\Mvc\User\Plugin
{
    public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher)
    {
        $annotations = $this->annotations->getMethod($dispatcher->getControllerClass(), $dispatcher->getActiveMethod());

        // 公开资源，任何用户都可访问
        if ($annotations->has('PublicAction')) {
            return true;
        }

        if (!$this->user->isLogined()) {
            $dispatcher->forward([
                'controller' => 'index',
                'action' => 'error',
                'params' => [
                    'msg' => '请先登录',
                    'url' => $this->url->get('index/login'),
                ]
            ]);
            return false;
        }

        // 基础资源，用户登录后就可访问
        if ($annotations->has('BaseAction')) {
            return true;
        }

        $controller = $dispatcher->getControllerName();
        $action = $dispatcher->getActionName();
        if ($this->user->isAllowed($controller . '/' . $action)) {
            return true;
        }

        $dispatcher->forward([
            'controller' => 'index',
            'action' => 'error',
            'params' => [
                'msg' => '没有权限',
            ]
        ]);
        return false;
    }
}