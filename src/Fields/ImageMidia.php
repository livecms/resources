<?php

namespace LiveCMS\Resources\Fields;

class ImageMidia extends Field
{
    public function toForm()
    {
        return [
            'type' => 'image-midia',
            'label' => $this->getLabel(),
        ];
    }
}
