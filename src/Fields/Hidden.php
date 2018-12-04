<?php

namespace LiveCMS\Resources\Fields;

class Hidden extends Field
{
    public function toDatatable()
    {
        return false;
    }

    public function toShow()
    {
        return false;
    }

    public function toForm()
    {
        return [
            'type' => 'hidden',
            'default' => $this->value,
            'label' => $this->getLabel(),
        ];
    }
}
