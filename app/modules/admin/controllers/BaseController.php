<?php
namespace App\Modules\Admin\Controllers;

/**
 * 后台基类
 * 提供一些公用方法
 * @author zhanpeng liu <liuzhanpeng@gmail.com>
 */
abstract class BaseController extends \Phalcon\Mvc\Controller
{
    /**
     * 返回响应信息
     * @param array $data 响应信息
     * @return mixed
     */
    protected function info(array $data)
    {
        if ($this->request->isAjax()) {
            return $this->json($data);
        }

        $tpl = $data['status'] == 1 ? 'include/success' : 'include/error';
        $view = $this->view;
        return $view->render($tpl, $data);
    }

    /**
     * 返回错误响应
     * @param string $msg 错误信息
     * @param array $data 扩展数据
     * @return mixed
     */
    protected function error(string $msg, array $data = []) 
    {
        $data['status'] = 0;
        $data['msg'] = $msg;
        return $this->info($data);
    } 

    /**
     * 返回成功响应
     * @param string $msg 信息
     * @param array $data 扩展数据
     * @return mixed
     */
    protected function success(string $msg, array $data = []) 
    {
        $data['status'] = 1;
        $data['msg'] = $msg;
        return $this->info($data);
    } 

    /**
     * 返回json响应
     * @param array $data 数据
     * @return \Phalcon\Http\Response
     */
    protected function json(array $data)
    {
        $response = new \Phalcon\Http\Response();
        $response->setContentType('application/json');
        $response->setJsonContent($data);

        return $response;
    }

    /**
     * 渲染视图
     * @param string $view 视频地址
     * @return string
     */
    protected function render(string $view = '')
    {
        if ($view == '') {
            $controllerName = $this->dispatcher->getControllerName();
            $actionName = $this->dispatcher->getActionName();
            return $this->view->render($controllerName . '/' . $actionName);
        }
        return $this->view->render($view); 
    }
}
