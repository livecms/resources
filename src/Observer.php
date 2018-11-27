<?php

namespace LiveCMS\Resources;

use LiveCMS\MediaLibrary\HasMediaLibrary;
use LiveCMS\MediaLibrary\MediaLibraryTrait;

class Observer
{
    use MediaLibraryTrait;

    public function creating($model)
    {
        //
    }

    public function created($model)
    {
        //
    }

    public function updating($model)
    {
        //
    }

    public function updated($model)
    {
        //
    }

    public function deleting($model)
    {
        //
    }

    public function deleted($model)
    {
        //
    }

    public function saving($model)
    {
        if ($model instanceof HasMediaLibrary) {
            $this->addMedia($model);
        }
    }

    public function saved($model)
    {
        //
    }
}