<?php

namespace LiveCMS\Resources;

use Illuminate\Support\HtmlString;
use LiveCMS\DataTables\DataTables;

trait Datatable
{
    public function getDatatable()
    {
        $datatables = new DataTables($this);
        if (($defaultSorts = $this->getDefaultSort()) != []) {
            $datatables->setDefaultOrder($defaultSorts);
        }

        return $datatables;
    }

    public function toDataTablesQuery()
    {
        return $this->model()->newQuery();
    }

    public function getDatatableFields()
    {
        $fields = [];
        foreach ($this->fields($this->request) as $field) {
            if ($field->is('onIndex') && $datatable = $field->toDatatable()) {
                if (is_array($datatable)) {
                    $fields[key($datatable)] = array_first($datatable);
                } else {
                    $fields[] = $datatable;
                }
            }
        }
        return $fields;
    }

    public function getDefaultSort()
    {
        $sort = [];
        $number = 0;
        foreach ($this->fields($this->request) as $field) {
            if ($field->is('onIndex') && $datatable = $field->toDatatable()) {
                if ($field->getDefaultSort() != false) {
                    $sort[] = [$number, $field->getDefaultSort()];
                }
            }
        }

        return $sort;
    }

    public function setActionField()
    {
        return [
            'orderable' => false,
            'searchable' => false,
            'resolve' => function ($row) {
                $id = $row->getKey();
                $showUrl = $this->toRoute('show', compact('id'));
                $editUrl = $this->toRoute('edit', compact('id'));
                $destroyUrl = $this->toRoute('destroy', compact('id'));
                return new HtmlString(
<<<HTML
                    <div class="action-buttons">
                        <a href="{$showUrl}" class="btn btn-link btn-xs" data-id="{$id}" title="Show"><i class="fa fa-eye"></i></a>
                        <a href="{$editUrl}" class="btn btn-link btn-xs" data-id="{$id}" title="Edit"><i class="fa fa-edit"></i></a>
                        <a href="{$destroyUrl}" class="btn btn-link btn-xs" data-id="{$id}" data-delete="form" title="Delete"><i class="fa fa-trash"></i></a>
                    </div>
HTML
                );
            },
            'width' => '15%',
            'className' => 'td-actions',
        ];
    }

    public function getDataTablesFields()
    {
        return $this->getDatatableFields() + ['' => $this->setActionField()];
    }
}
