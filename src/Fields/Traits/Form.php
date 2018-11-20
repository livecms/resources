<?php

namespace LiveCMS\Resources\Fields\Traits;

trait Form
{
    public function toForm()
    {
        return [
            'type' => 'text',
            'label' => $this->getLabel(),
        ];
    }
}
