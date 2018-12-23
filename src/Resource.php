<?php

namespace LiveCMS\Resources;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Validation\ValidatesRequests;

trait Resource
{
    use Datatable, Form, Show, ValidatesRequests, Validation;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->getDatatable()->renderView($this->request->url().'/datatable');
        return view(static::$baseView.'.index');
    }

    public function datatable()
    {
        return $this->getDatatable()->renderData();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->renderForm();
        $this->renderButton();
        return view(static::$baseView.'.create');
    }

    protected function afterStored($model)
    {
        return 
            redirect(
                    $this->toRoute('index')
                )->with(
                    'success',
                    __(
                        'New :resource_name has been created.',
                        ['resource_name' => static::$title]
                    )
                );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $this->validate(
            $this->request,
            $this->validationRules('create'),
            [],
            $this->getLabelFields('create')
        );

        if ($new = $this->model()->create($this->request->all())) {
            return $this->afterStored($new);
        }

        return
            back()
            ->withInput()
            ->with(
                'error',
                __(
                    'Error when creating :resource_name.',
                    ['resource_name' => static::$title]
                )
            );

    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        static::setInstanceModel($model = $this->model()->findOrFail($id));
        $this->renderShow($model);
        return view(static::$baseView.'.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        static::setInstanceModel($model = $this->model()->findOrFail($id));
        $this->renderForm($model);
        $this->renderButton($model);
        return view(static::$baseView.'.edit');
    }

    protected function afterUpdated($model)
    {
        return
            redirect(
                    $this->toRoute('index')
                )->with(
                    'success',
                    __(
                        ':resource_name has been updated.',
                        ['resource_name' => static::$title]
                    )
                );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $this->validate(
            $this->request,
            $this->validationRules('update'),
            [],
            $this->getLabelFields('update')
        );
        static::setInstanceModel($model = $this->model()->findOrFail($id));
        if ($exist = $model->update($this->request->all())) {
            return $this->afterUpdated($exist);
        }

        return $this->afterUpdated($exist);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = $this->model()->findOrFail($id);
        return ['success' => $model->delete()];
    }
}
