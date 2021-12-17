<?php

namespace App\Traits;

trait GetTableNameStatically
{
    public static function getTableName(): string
    {
        return (new static)->getTable();
    }
}
