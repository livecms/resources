<?php

namespace LiveCMS\Resources\Fields;

class Text extends Field
{
    public function toForm()
    {
        return [
            'type' => 'text',
            'label' => $this->getLabel(),
        ];
    }
}
