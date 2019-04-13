<?php
namespace App\Modules\Admin\Components;

use App\Components\Auth\AccessCheckInterface;
use App\Components\Auth\IdentityInterface;

class AccessChecker extends \Phalcon\Mvc\User\Component implements AccessCheckInterface
{
    public function isAllowed(IdentityInterface $identity, string $accessAction): bool
    {
        $admin = Admin::findFirst($identity->getId());
        if (!$admin) {
            return false;
        }

        // rooter有所有权限
        if ($admin->is_root) {
            return true;
        }

        // todo 缓存
        foreach ($admin->roles as $role) {
            foreach ($role->permissions as $permission) {
                $actions = explode(',', strtolower(trim($permission['actions'])));
                foreach ($actions as $action) {
                    if (strcmp(strtolower($accessAction), $action) === 0) {
                        return true;
                    }
                }
            }
        }

        return false;
    }
}