<?php

namespace LiveCMS\Resources;

use Illuminate\Database\Eloquent\Model;
use LiveCMS\Resources\Fields\ID;

trait Show
{
    public function renderShow(Model $model)
    {
        $showFields = [];
        $keyFieldLabel = $keyFieldValue = null;
        foreach ($this->fields($this->request) as $field) {
            if ($datatable = $field->is('onShow')) {
                $fieldName = $field->getField();
                $value = $model->$fieldName;
                if (!$keyFieldValue && $field instanceof ID) {
                    $keyFieldLabel = $field->getLabel();
                    $keyFieldValue = $field->toShow($value);
                    continue;
                }
                $showFields[$field->getLabel()] = $field->toShow($value);
            }
        }

        if (!$keyFieldValue) {
            $keyFieldLabel = key($showFields);
            $keyFieldValue = array_shift($showFields);
        }

        view()->share(compact('showFields', 'keyFieldLabel', 'keyFieldValue'));
    }

    public function getShowFields()
    {
        $fields = [];
        foreach ($this->fields($this->request) as $field) {
            if ($field->is('onShow')) {
                $fields[$field->getLable()] = $field->toShow();
            }
        }
        return $fields;
    }
}