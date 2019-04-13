<?php
namespace App\Models;

class Role extends BaseModel
{
    public function initialize()
    {
        $this->hasManyToMany(
           'id',
           __NAMESPACE__ . '\RolePermissionRelation',
           'role_id',
           'permission_id',
           __NAMESPACE__ . '\Permission',
           'id',
           [
               'alias' => 'permissions'
           ] 
        );
    }
}