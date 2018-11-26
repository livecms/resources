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
                    $field = $this->field;
                    $img = $this->value();
                    return $img == null
                        ? __('No Image')
                        : (new HtmlString('<img src="'.$img.'" style="max-height: 50px;">'));
                },
            ],
        ];
    }

    public function value()
    {
        return parent::value() ?? $this->model->media->where('field', $this->field)->first()->thumbnail ?? null;
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
            'label' => $this->getLabel(),
        ];
    }
}
