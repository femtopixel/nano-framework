<?php
namespace Nano;

abstract class Model
{
    /**
     * @param string $name
     * @return mixed
     * @codeCoverageIgnore
     */
    public function getDb($name = 'default')
    {
        return Db::getInstance($name);
    }
}
