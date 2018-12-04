<?php

namespace LiveCMS\Resources\Fields;

class Link extends Hiden
{
    public function toForm()
    {
        return [
            'type' => 'link',
            'default' => $this->value,
            'label' => $this->getLabel(),
        ];
    }
}
