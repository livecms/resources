<?php

namespace LiveCMS\Resources\Fields;

class Button extends Hidden
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
            'type' => 'button',
            'default' => $this->value,
            'label' => $this->getLabel(),
        ];
    }
}
