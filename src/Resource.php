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
        return view(static::$baseView.'.create');
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

        if ($this->model()->create($this->request->all())) {
            return
                redirect(
                    static::route('index')
                )->with(
                    'success',
                    __(
                        'New :resource_name has been created.',
                        ['resource_name' => static::$title]
                    )
                );
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
        return view(static::$baseView.'.edit');
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
        if ($model->update($this->request->all())) {
            return
                redirect(
                    static::route('index')
                )->with(
                    'success',
                    __(
                        ':resource_name has been updated.',
                        ['resource_name' => static::$title]
                    )
                );
        }

        return
            back()
            ->withInput()
            ->with(
                'error',
                __(
                    'Error when updating :resource_name.',
                    ['resource_name' => static::$title]
                )
            );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
    }
}
