<?php
namespace App\Components;

use Gregwar\Captcha\PhraseBuilder;
use Gregwar\Captcha\CaptchaBuilder;

/**
 * 验证码组件
 * 第三方组件Gregwar/Captcha的二次封装
 * @author zhanpeng liu <liuzhanpeng@gmail.com>
 */
class Captcha extends \Phalcon\Mvc\User\Component
{
    /**
     * session key
     * @var string
     */
    private $key = 'captcha';

    /**
     * session 超时时间
     * @var integer
     */
    private $lifetime = 60 * 10;

    /**
     * 验证码图片高度
     * @var integer
     */
    private $width = 150;

    /**
     * 验证码图片高度
     * @var integer
     */
    private $height = 40;

    /**
     * 验证码位数
     * @var integer
     */
    private $len = 5;

    /**
     * 来源字符集
     * @var string
     */
    private $charset = 'abcdefghijklmnpqrstuvwxyz123456789';

    /**
     * 构造函数
     * @param Phalcon\Config $params 配置
     */
    public function  __construct(\Phalcon\Config $params)
    {
        $this->key = $params->get('key', $this->key);
        $this->lifetime = $params->get('lifetime', $this->lifetime);
        $this->len = $params->get('len', $this->len);
        $this->width = $params->get('width', $this->width);
        $this->height = $params->get('height', $this->height);
        $this->charset = $params->get('charset', $this->charset);
    }

    /**
     * 输出验证码（二进制数据)
     */
    public function render()
    {
        $phraseBuilder = new PhraseBuilder($this->len, $this->charset);
        $captchaBuilder = new CaptchaBuilder(null, $phraseBuilder);
        $captchaBuilder->build($this->width, $this->height);

        $this->session->set($this->key, [
            'phrase' => $captchaBuilder->getPhrase(),
            'expire' => time() + $this->lifetime,
        ]);

        $captchaBuilder->output();
    }

    /**
     * 检查码证码是否正确
     * @param string $code 验证码
     * @param bool $unset 检查后是否删除session 
     */
    public function check(?string $code, bool $unset = true) : bool
    {
        if (!$code) {
            return false;
        }
        if(!$this->session->has($this->key)) {
            return false;
        }

        $captchaSession = $this->session->get($this->key);
        if ($unset) {
            $this->session->remove($this->key);
        }

        return strcasecmp($captchaSession['phrase'], $code) == 0 && $captchaSession['expire'] >= time();
    }
}