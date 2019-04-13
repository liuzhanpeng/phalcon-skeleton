<?php
namespace App\Models;

class BaseModel extends \Phalcon\Mvc\Model
{
    public function initialize()
    {
        $this->useDynamicUpdate(true);

        // $this->setWriteConnectionService('db');
        // $this->setReadConnectionService('dbSlave');
    }
}
