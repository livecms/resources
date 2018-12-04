<?php

namespace LiveCMS\Resources\Fields;

class TinyMCE extends Field
{
    public function toDatatable()
    {
        return [
            $this->label => [
                'name' => $this->field,
                'orderable' => false,
                'resolve' => function ($row) {
                    return str_limit(
                        strip_tags(
                            $row->{$this->field}
                        ),
                        250
                    );
                },
            ],
        ];
    }

    public function toForm()
    {
        return [
            'type' => 'tinymce',
            'default' => $this->value,
            'label' => $this->getLabel(),
        ];
    }
}
