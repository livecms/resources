<?php

namespace LiveCMS\Resources\Fields;

class Textarea extends Field
{
    public function toForm()
    {
        return [
            'type' => 'textarea',
            'label' => $this->getLabel(),
        ];
    }
}
