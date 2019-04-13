<?php
namespace App\Modules\Admin\Controllers;

use App\Core\Components\Auth\AuthenticationException;

class IndexController extends BaseController
{
    /**
     * @BaseAction
     */
    public function indexAction()
    {
        return $this->view->render('index/index');
    }

    /**
     * @PublicAction
     */
    public function loginAction()
    {
        if (!$this->request->isPost()) {
            return $this->render();
        }

        $account = $this->request->getPost('account');
        $passwd = $this->request->getPost('passwd');
        $captcha = $this->request->getPost('captcha');

        if (!$this->captcha->check($captcha)) {
            return $this->error('验证码错误');
        }

        try {
            $this->user->login([
                'account' => $account,
                'passwd' => $passwd,
            ]);
            return $this->success('登录成功', [
                'url' => $this->url->get('index/index')
            ]);
        } catch(AuthenticationException $ex) {
            return $this->error($ex->getMessage());
        }
    }

    /**
     * @PublicAction
     */
    public function captchaAction()
    {
        header('Content-type: image/jpeg');
        $this->captcha->render();
    }

    /**
     * @BaseAction
     */
    public function logoutAction()
    {
        $this->user->logout();
        return $this->response->redirect('index/login');
    }

    /**
     * @PublicAction
     */
    public function errorAction()
    {
        $params = $this->dispatcher->getParams();
        return $this->error($params['msg'], $params);
    }
}
