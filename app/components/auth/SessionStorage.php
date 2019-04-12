<?php
namespace App\Components\Auth;

/**
 * Session 身份存储器
 * @author zhanpeng liu <liuzhanpeng@gmail.com>
 */
class SessionStorage extends \Phalcon\Mvc\User\Component implements StorageInterface
{
    /**
     * 会话key
     * @var string
     */
    private $key;

    /**
     * 构造函数
     * @param string $key 会话key
     */
    public function __construct(\Phalcon\Config $params)
    {
        $this->key = $params->get('key', 'UserIdentity');
    }

    /**
     * 保存身份
     * @param IdentityInterface $identity 身份信息
     */
    public function setIdentity(?IdentityInterface $identity)
    {
        if ($identity != null) {
            $this->session->set($this->key, $identity);
        }
    }

    /**
     * 返回身份
     * @return IdentityInterface | null
     */
    public function getIdentity(): ?IdentityInterface
    {
        return $this->session->get($this->key);
    }

    // /**
    //  * 是否存在身份
    //  * @return bool
    //  */
    // public function hasIdentity(): bool
    // {
    //     return $this->session->has($this->key);
    // }

    /**
     * 清除身份
     */
    public function removeIdentity()
    {
        $this->session->remove($this->key);
    }
}
