<?php

namespace LiveCMS\Resources;

use Illuminate\Database\Eloquent\Model;
use LiveCMS\Form\Forms;
use LiveCMS\MediaLibrary\MediaLibraryTrait;

trait Form
{
    use MediaLibraryTrait;

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

    public function renderButton(Model $model = null)
    {
        $button = Forms::create()
                    ->setComponents(
                        $this->getFormButtons($model === null)
                    );
        $button = $button->setName('button')->render();
        // view()->share(compact('button'));
    }

    public function getFormFields($create = false)
    {
        return $this->processFields($this->fields($this->request), $Old = [], $create);
    }

    public function processFields($theFields = [], $old = [], $create = false)
    {
        $fields = $old;
        foreach ($theFields as $field) {
            if ($create ? $field->is('onCreate') : $field->is('onEdit')) {
                if ($form = $field->toForm()) {
                    $fields[$field->getField()] = $form;
                }
            }
        }
        return $fields;
    }

    public function getFormButtons($create = false)
    {
        if (!method_exists($this, 'buttons')) {
            return [];
        }

        $buttons = [];
        foreach ($this->buttons($this->request) as $button) {
            if ($create ? $button->is('onCreate') : $button->is('onEdit')) {
                if ($collection = $button->toForm()) {
                    $buttons[$button->getField()] = $collection;
                }
            }
        }
        return $buttons;
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