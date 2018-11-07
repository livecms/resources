<?php

namespace LiveCMS\Resources;

trait Validation
{
    public function validationRules($state)
    {
        $rules = [];
        foreach ($this->fields($this->request) as $field) {
            if ($state == 'create' ? $field->is('onCreate') : $field->is('onEdit')) {
                $rules[$field->getField()] = $field->getValidators($state);
            }
        }
        return $rules;
    }
}
