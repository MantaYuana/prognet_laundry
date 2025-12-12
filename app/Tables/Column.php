<?php

namespace App\Tables;

class Column
{
    public string $key;
    public string $label;

    public function __construct($key, $label)
    {
        $this->key = $key;
        $this->label = $label;
    }

    public static function make($key, $label)
    {
        return new static($key, $label);
    }
}
