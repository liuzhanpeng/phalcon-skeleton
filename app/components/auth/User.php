<?php
namespace App\Components\Auth;

/**
 * 用户组件
 * @author zhanpeng liu <liuzhanpeng@gmail.com>
 */
class User extends \Phalcon\Mvc\User\Component
{
    /**
     * 认证组件
     * @var AuthenticateInterface
     */
    private $authenticator;

    /**
     * 访问权限检查组件
     * @var AccessCheckInterface
     */
    private $accessChecker;

    /**
     * 身份存储器
     * @var StorageInterface
     */
    private $storage;

    /**
     * 构造函数
     */
    public function __construct(\Phalcon\Config $config)
    {
        if ($config->get('authenticator') == null) {
            throw new AuthenticationException('请配置user服务的authenticator组件');
        }
        $authenticatorClass = $config->get('authenticator')->get('className');
        $authenticatorParams = $config->get('authenticator')->get('params');
        $this->authenticator = new $authenticatorClass($authenticatorParams);

        if ($config->get('accessChecker') !=  null) {
            $accessCheckerClass = $config->get('accessChecker')->get('className');
            $accessCheckerParams = $config->get('accessChecker')->get('params');
            $this->accessChecker = new $accessCheckerClass($accessCheckerParams);
        }

        if ($config->get('storage') != null) {
            $storageClass = $config->get('storage')->get('className');
            $storageParams = $config->get('storage')->get('params');
            $this->storage = new $storageClass($storageParams);
        } else {
            $this->storage = new SessionStorage(new \Phalcon\Config(['key' => 'UserIdentity']));
        }
    }

    /**
     * 用户登录
     * @param array $credentials 凭证
     */
    public function login(array $credentials)
    {
        $eventsManager = $this->eventsManager;

        try {
            $eventsManager->fire('user:beforeLogin', $this, $credentials);

            $identity = $this->authenticator->authenticate($credentials);
            $this->storage->setIdentity($identity);

            $eventsManager->fire('user:afterLogin', $this, $identity);
        } catch (AuthenticationException $ex) {
            $eventsManager->fire('user:beforeLoginException', $this, $ex);
            throw $ex;
        }
    }

    /**
     * 用户登出
     */
    public function logout()
    {
        $eventsManager = $this->eventsManager;

        $identity = $this->storage->getIdentity();

        $eventsManager->fire('user:beforeLogout', $this, $identity);
        $this->storage->removeIdentity();
        $eventsManager->fire('user:afoterLogout', $this, $identity);
    }

    /**
     * 是否已登录
     * @return bool
     */
    public function isLogined() : bool
    {
        return $this->storage->getIdentity() != null;
    }

    /**
     * 返回用户身份信息
     */
    public function getIdentity()
    {
        return $this->storage->getIdentity();
    }

    /**
     * 是否属于指定角色
     * @param string $role 角色
     * @return bool
     */
    public function inRole(string $role) : bool
    {
        if ($this->isLogined()) {
            return false;
        }
        $identity = $this->getIdentity();
        return in_array($role, $identity->getRoles());
    }

    /**
     * 是否有访问指定action的权限
     */
    public function isAllowed(string $action) : bool
    {
        if (!$this->accessChecker) {
            throw new \Exception('请配置user服务的accessChecker组件');
        }
        if (!$this->isLogined()) {
            return false;
        }

        return $this->accessChecker->isAllowed($this->getIdentity(), $action);
    }
}
