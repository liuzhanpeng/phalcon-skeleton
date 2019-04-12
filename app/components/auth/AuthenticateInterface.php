<?php
namespace App\Components\Auth;

/**
 * 认证接口
 * @author zhanpeng liu <liuzhanpeng@gmail.com>
 */
interface AuthenticateInterface
{
    /**
     * 验证用户凭证是否合法
     * @param array 用户凭证
     * @return IdentityInterface
     * @throws AuthenticationException
     */
    public function authenticate(array $credentials): IdentityInterface;
}
