<?php

namespace LiveCMS\Resources\Fields\Traits;

trait Datatable
{
    public function toDatatable()
    {
        if (!$this->sortable) {
            return [
                $this->label => [
                    'name' => $this->field,
                    'orderable' => false,
                ],
            ];
        }
        return [
            $this->label => $this->field
        ];
    }

    public function sortable($true = true)
    {
        $this->sortable = $true;
        return $this;
    }
}
