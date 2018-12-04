<?php

namespace LiveCMS\Resources\Fields;

use Illuminate\Support\HtmlString;

class Image extends Field
{
    public function toDatatable()
    {
        return [
            $this->label => [
                'name' => $this->field,
                'orderable' => false,
                'resolve' => function ($row) {
                    $this->setModel($row);
                    $img = $this->value();
                    return $img == null
                        ? __('No Image')
                        : (new HtmlString('<img src="'.$img.'" style="max-height: 50px;">'));
                },
            ],
        ];
    }

    public function toShow()
    {
        $img = $this->value();
        return $img == null ? __('No Image') : new HtmlString('<img src="'.$img.'" style="max-height: 150px;">');
    }

    public function toForm()
    {
        return [
            'type' => 'image',
            'default' => $this->value,
            'label' => $this->getLabel(),
        ];
    }
}
