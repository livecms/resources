<?php

namespace LiveCMS\Resources\Fields;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use LiveCMS\Resources\Fields\Contracts\Datatableable;
use LiveCMS\Resources\Fields\Contracts\Formable;
use LiveCMS\Resources\Fields\Contracts\Showable;
use LiveCMS\Resources\Fields\Contracts\Validable;
use LiveCMS\Resources\Fields\Traits\Datatable;
use LiveCMS\Resources\Fields\Traits\Form;
use LiveCMS\Resources\Fields\Traits\Show;
use LiveCMS\Resources\Fields\Traits\Validation;
use LiveCMS\Resources\Fields\Traits\Visibility;

abstract class Field implements Datatableable, Formable, Showable, Validable
{
    use Datatable, Form, Show, Visibility, Validation;

    protected $model;
    protected $field;
    protected $label;
    protected $value;
    protected $validators;
    protected $creatingValidators;
    protected $updatingValidators;
    protected $defaultSort;
    protected $sortable = false;
    protected $onIndex = true;
    protected $onCreate = true;
    protected $onShow = true;
    protected $onEdit = true;

    public function __construct($label, $field = null)
    {
        $this->label = $label;
        $this->field = $field ?? Str::snake(strtolower($label));
    }

    public static function make(...$params)
    {
        return new static(...$params);
    }

    public function getField()
    {
        return $this->field;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    public function value()
    {
        return $this->model->{$this->field} ?? $this->value;
    }
}
