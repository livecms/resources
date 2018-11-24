<?php

namespace LiveCMS\Resources\Fields;

class Image extends Field
{
    public function toForm()
    {
        return [
            'type' => 'image',
            'label' => $this->getLabel(),
        ];
    }
}
