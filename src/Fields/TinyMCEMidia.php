<?php

namespace LiveCMS\Resources\Fields;

class TinyMCEMidia extends TinyMCE
{
    public function toForm()
    {
        return [
            'type' => 'tinymce-midia',
            'label' => $this->getLabel(),
        ];
    }
}
