<?php

namespace LiveCMS\Resources\Fields\Traits;

trait Form
{
    public function toForm()
    {
        return [
            'type' => 'text',
            'default' => $this->value,
            'label' => $this->getLabel(),
        ];
    }
}
