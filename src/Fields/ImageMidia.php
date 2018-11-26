<?php

namespace LiveCMS\Resources\Fields;

class ImageMidia extends Image
{
    public function value()
    {
        return $this->model->media->where('field', $this->field)->first()->thumbnail ?? null;
    }

    public function toForm()
    {
        return [
            'type' => 'image-midia',
            'label' => $this->getLabel(),
        ];
    }
}
