<?php

namespace LiveCMS\Resources\Fields\Traits;

trait Show
{
    public function toShow()
    {
        return $this->value();
    }
}
