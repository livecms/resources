<?php

namespace LiveCMS\Resources\Fields;

class TinyMCE extends Field
{
    public function toForm()
    {
        return [
            'type' => 'tinymce',
            'label' => $this->getLabel(),
        ];
    }
}
