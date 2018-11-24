<?php

namespace LiveCMS\Resources\Fields;

class TinyMCEMidia extends Field
{
    public function toForm()
    {
        return [
            'type' => 'tinymce-midia',
            'label' => $this->getLabel(),
        ];
    }
}
