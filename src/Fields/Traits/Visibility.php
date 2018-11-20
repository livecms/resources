<?php

namespace LiveCMS\Resources\Fields\Traits;

trait Visibility
{
    public function showAll()
    {
        $this->onIndex =
        $this->onCreate =
        $this->onShow =
        $this->onEdit = true;
        return $this;
    }

    public function hideAll()
    {
        $this->onIndex =
        $this->onCreate =
        $this->onShow =
        $this->onEdit = false;
        return $this;
    }

    public function hideAllExcept($key)
    {
        $this->hideAll();
        $keys = is_array($key) ? $key : func_get_args();
        foreach ($keys as $key) {
            if (method_exists($this, $func = 'on'.title_case($key))) {
                $this->$func = true;
            }
        }
        return $this;
    }

    public function hideFromIndex()
    {
        $this->onIndex = false;
        return $this;
    }

    public function hideFromDetail()
    {
        $this->onShow = false;
        return $this;
    }

    public function hideWhenCreating()
    {
        $this->onCreate = false;
        return $this;
    }

    public function hideWhenUpdating()
    {
        $this->onEdit = false;
        return $this;
    }

    public function onlyOnIndex()
    {
        return $this->hideAllExcept('index');
    }

    public function onlyOnDetail()
    {
        return $this->hideAllExcept('show');
    }

    public function onlyOnForms()
    {
        return $this->hideAllExcept('create', 'edit');
    }

    public function exceptOnForms()
    {
        return 
            $this->showAll()
            ->hideWhenCreating()
            ->hideWhenUpdating();
    }

    public function is($key)
    {
        return ($this->{$key} ?? false) === true;
    }
}
