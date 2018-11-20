<?php

namespace LiveCMS\Resources\Fields\Contracts;

interface Validable
{
    public function getValidators($state);
    public function rules();
    public function creationRules();
    public function updateRules();
}
