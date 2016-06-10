<?php
namespace Nano;


abstract class Model
{
    /**
     * @param string $name
     * @return mixed
     */
    public function getDb($name = 'default')
    {
        return Db::getInstance($name);
    }
}
