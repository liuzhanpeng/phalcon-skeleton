<?php
namespace App\Components\Auth;

/**
 * 用户身份接口
 * @author zhanpeng liu <liuzhanpeng@gmail.com>
 */
interface IdentityInterface
{
    /**
     * 返回用户标识
     * @return mixed
     */
    public function getId();

    /**
     * 返回用户所属角色列表
     * @return array
     */
    public function getRoles(): array;

    /**
     * 返回用户信息
     * @return array
     */
    public function getData(): array;
}
