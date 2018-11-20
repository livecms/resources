<?php

namespace LiveCMS\Resources\Fields\Contracts;

interface Datatableable
{
    public function toDatatable();
    public function sortable($true = true);
}
