<?php
namespace App\Modules\Admin\Components;

use App\Components\Auth\AuthenticateInterface;
use App\Components\Auth\IdentityInterface;
use App\Components\Auth\Identity;
use App\Components\Auth\AuthenticationException;
use App\Models\Admin;

class Authenticator extends \Phalcon\Mvc\User\Component implements AuthenticateInterface
{
    public function authenticate(array $credentials): IdentityInterface
    {
        if (!isset($credentials['account']) && !isset($credentials['passwd'])) {
            throw new AuthenticationException('账号或密码错误');
        }

        $admin = Admin::findFirstByAccount($credentials['account']);
        if (!$admin || !$this->security->checkHash($credentials['passwd'], $admin->passwd)) {
            throw new AuthenticationException('账号或密码错误');
        } 
        if ($admin->status != 1) {
            throw new AuthenticationException('账号已被锁定');
        }

        // 获取所属角色列表
        $roles = [];
        foreach($admin->roles as $role) {
            $roles[] = $role->name;
        }

        return new Identity($admin->id, $roles, [
            'account' => $admin->account,
            'name' => $admin->name,
            'is_root' => $admin->is_root,
        ]);
    }
}