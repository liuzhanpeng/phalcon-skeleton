<?php
namespace App\Components\Auth;

/**
 * 访问权限检查接口
 * @author zhanpeng liu <liuzhanpeng@gmail.com>
 */
interface AccessCheckInterface
{
    /**
     * 检查用户是否能访问指定action
     * @param IdentityInterface $identity 身份
     * @param string $accessAction 要访问的action
     * @return bool
     */
    public function isAllowed(IdentityInterface $identity, string $accessAction): bool;
}
