<?php
namespace App\Providers;

/**
 * 验证码服务提供器
 * @author zhanpeng liu <liuzhanpeng@gmail.com>
 */
class CaptchaProvider extends AbstractProvider
{
    public function register(\Phalcon\DiInterface $di)
    {
        $params = $this->params;
        $di->setShared($this->name, function() use ($params) {
            $captcha = new \App\Components\Captcha($params);

            return $captcha;
        });
    }
}