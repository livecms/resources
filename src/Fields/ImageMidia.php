<?php

namespace LiveCMS\Resources\Fields;

class ImageMidia extends Image
{
    public function toForm()
    {
        return [
            'type' => 'image-midia',
            'label' => $this->getLabel(),
        ];
    }
}
