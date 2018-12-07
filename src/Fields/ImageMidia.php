<?php

namespace LiveCMS\Resources\Fields;

class ImageMidia extends Image
{
    public function value()
    {
        return $this->model->getMediaData($this->field)->thumbnail ?? null;
    }

    public function toForm()
    {
        return [
            'type' => 'image-midia',
            'default' => $this->value,
            'label' => $this->getLabel(),
        ];
    }
}
