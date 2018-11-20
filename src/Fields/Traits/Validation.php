<?php

namespace LiveCMS\Resources\Fields\Traits;

trait Validation
{
    public function getValidators($state = null)
    {
        $validators = $this->validators ?? [];
        if ($state == 'create') {
            return $validators + ($this->creatingValidators ?? []);
        }
        if ($state == 'update') {
            return $validators + ($this->updatingValidators ?? []);
        }
        return $validators;
    }

    public function rules()
    {
        $args = func_get_args();
        $this->validators = count($args) == 1 ? (array) array_first($args) : $args;
        return $this;
    }

    public function creationRules()
    {
        $args = func_get_args();
        $this->creatingValidators = count($args) == 1 ? (array) array_first($args) : $args;
        return $this;
    }

    public function updateRules()
    {
        $args = func_get_args();
        $this->updatingValidators = count($args) == 1 ? (array) array_first($args) : $args;
        return $this;
    }
}
