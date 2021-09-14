<?php

namespace App\Traits;

trait CanGetTableNameStatically
{
    public static function getTableName(): string
    {
        return (new static)->getTable();
    }
}
