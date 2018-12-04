<?php

namespace LiveCMS\Resources\Fields;

class TinyMCEMidia extends TinyMCE
{
    public function toForm()
    {
        return [
            'type' => 'tinymce-midia',
            'default' => $this->value,
            'label' => $this->getLabel(),
        ];
    }
}
