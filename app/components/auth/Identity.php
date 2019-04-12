<?php
namespace App\Components\Auth;

/**
 * 用户身份类
 * @author zhanpeng liu <liuzhanpeng@gamil.com>
 */
class Identity implements IdentityInterface
{
    /**
     * 用户标识
     * @var mixed
     */
    protected $id;

    /**
     * 用户所属角色列表
     * @var array
     */
    protected $roles;

    /**
     * 用户信息
     * @var array
     */
    protected $data;

    /**
     * 构造函数
     * @param mixed $id 用户标识
     * @param array $roles 用户所属角色列表
     * @param array $data 用户信息
     */
    public function __construct($id, array $roles = [], array $data = [])
    {
        $this->id = $id;
        $this->roles = $roles;
        $this->data = $data;
    }

    /**
     * 返回用户标识
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 返回用户所属角色
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * 设置用户所属角色
     * @param array $roles 角色列表
     */
    public function setRoles(array $roles)
    {
        $this->roles = $roles;
    }

    /**
     * 返回用户信息
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * 设置用户信息
     * @param array $data 用户信息
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    public function __get(string $key)
    {
        return $this->data[$key];
    }

    public function __set($key, $val)
    {
        $this->data[$key] = $val;
    }

    public function __isset($key)
    {
        return isset($this->data[$key]);
    }
}
