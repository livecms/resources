<?php

namespace LiveCMS\Resources\Fields;

class ID extends Text
{
    public static function make(...$params)
    {
        $label = array_shift($params) ?? 'ID';
        return parent::make($label, ...$params)->setDefaultSort('desc');
    }
}
