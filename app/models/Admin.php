<?php
namespace App\Models;

class Admin extends BaseModel
{
    public function initialize()
    {
        $this->hasManyToMany(
            'id',
            __NAMESPACE__ . '\AdminRoleRelation',
            'admin_id',
            'role_id',
            __NAMESPACE__ . '\Role',
            'id',
            [
                'alias' => 'roles'
            ]
        );
    }
}