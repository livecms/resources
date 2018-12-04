<?php

namespace LiveCMS\Resources\Fields;

class LinkButton extends Hidden
{
    public function toForm()
    {
        return [
            'type' => 'link-button',
            'default' => $this->value,
            'label' => $this->getLabel(),
        ];
    }
}
