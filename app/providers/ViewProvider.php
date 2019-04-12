<?php
namespace App\Providers;

/**
 * 视图服务提供器
 * @author zhanpeng liu <liuzhanpeng@gmail.com>
 */
class ViewProvider extends AbstractProvider
{
    public function register(\Phalcon\DiInterface $di)
    {
        $di->setShared($this->name, function () {
            $viewsDir =  APP_PATH . '/modules/' . $this->get('router')->getModuleName() . '/views/';

            $view = new \Phalcon\Mvc\View\Simple();
            $view->setEventsManager($this->get('eventsManager'));
            $view->setViewsDir($viewsDir);
            $view->registerEngines([
                '.html' => 'Phalcon\Mvc\View\Engine\Php',
            ]);

            return $view;
        });
    }
}
