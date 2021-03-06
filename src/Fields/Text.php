<?php

namespace LiveCMS\Resources\Fields;

class Text extends Field
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
