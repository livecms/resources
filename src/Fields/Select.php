<?php

namespace LiveCMS\Resources\Fields;

class Select extends Field
{
    protected $options = [];
    protected $usingLabel = false;

    public function options(array $options)
    {
        $this->options = $options;
        return $this;
    }

    public function displayUsingLabels($state = true)
    {
        $this->usingLabel = $state;
        return $this;
    }

    public function toDatatable()
    {
        return [
            $this->label => [
                'name' => $this->field,
                'orderable' => $this->usingLabel ? false : $this->sortable,
                'resolve' => function ($row) {
                    $this->setModel($row);
                    $value = $this->value();
                    return $this->usingLabel ? $this->options[$value] : $value;
                },
            ],
        ];
    }

    public function toShow()
    {
        $value = $this->value();
        return $this->usingLabel ? $this->options[$value] : $value;
    }

    public function toForm()
    {
        return [
            'type' => 'select',
            'label' => $this->getLabel(),
            'default' => $this->value,
            'options' => $this->options,
        ];
    }
}
