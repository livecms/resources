<?php

namespace LiveCMS\Resources;

use Illuminate\Database\Eloquent\Model;
use LiveCMS\Form\Forms;

trait Form
{
    public function renderForm(Model $model = null)
    {
        $form = Forms::create()
                    ->setComponents(
                        $this->getFormFields($model === null)
                    )
                    ->useValidation();
        if ($model) {
            $form->fill($model->toArray());
        }
        $form = $form->setName('form')->render();
        // view()->share(compact('form'));
    }

    public function getFormFields($create = false)
    {
        $fields = [];
        foreach ($this->fields($this->request) as $field) {
            if ($create ? $field->is('onCreate') : $field->is('onEdit')) {
                if ($form = $field->toForm()) {
                    $fields[$field->getField()] = $form;
                }
            }
        }
        return $fields;
    }

    public function getLabelFields($create = false)
    {
        $labels = [];
        foreach ($this->fields($this->request) as $field) {
            if ($create ? $field->is('onCreate') : $field->is('onEdit')) {
                $labels[$field->getField()] = $field->getLabel();
            }
        }
        return $labels;
    }
}