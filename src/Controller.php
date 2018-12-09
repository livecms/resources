<?php

namespace LiveCMS\Resources;

use BadMethodCallException;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use LiveCMS\DataTables\HasDataTables;

abstract class Controller implements HasDataTables
{
    use Resource;

    protected $request;
    protected $instanceModel;
    protected static $baseView;
    protected static $allInstanceModels = [];

    public function __construct()
    {
        if (!property_exists(static::class, 'model')) {
            throw new Exception("Please define a model first", 1);
        }
        $this->request = app('request');
        static::$model::observe(new Observer);
        static::$model::observe($this);
    }

    public function getCurrentAction()
    {
        $action = null;
        if ($route = app('request')->route()) {
            $action = $route->getAction();
        }

        return $action;
    }

    public function baseRoute()
    {
        $parts = explode('.', $this->getCurrentAction()['as']);
        array_pop($parts);
        return implode('.', $parts);
    }

    public function toRoute($route, $params = [])
    {
        return route($this->baseRoute().'.'.$route, $params);
    }

    public function getCurrentController()
    {
        $controller = null;
        if ($action = $this->getCurrentAction()) {
            $controller = $action['controller'];
            list($controller, $action) = explode('@', $controller);
        }

        return $controller;
    }

    public static function register($uri = null)
    {
        if (!property_exists(static::class, 'model')) {
            throw new Exception("Please define a model first", 1);
        }

        static::routeTo($uri ?? static::getUri());
    }

    public static function getName()
    {
        return property_exists(static::class, 'name')
                ? static::$name
                : Str::replaceLast('Resource', '', basename(
                        str_replace('\\', '//', static::$model)
                    ), '-');
    }

    public static function getCaption()
    {
        return property_exists(static::class, 'caption')
                ? static::$caption
                : title_case(snake_case(static::getName(), ' '));
    }

    public static function getTitleField()
    {
        return property_exists(static::class, 'title')
                ? static::$title
                : 'name';
    }

    public static function getUri()
    {
        return property_exists(static::class, 'uri')
                ? static::$uri
                : Str::snake(static::getName(), '-');
    }

    public static function getWith()
    {
        return property_exists(static::class, 'with')
                ? static::$with
                : [];
    }

    public static function getBaseRoute()
    {
        $controller = static::class;
        $routeCollection = Route::getRoutes();
        $action = $controller.'@index';
        $route = $routeCollection->getByAction($action);
        return Str::replaceLast('.index', '', $route->getAction()['as']);
    }

    public static function route($route, array $params = [])
    {
        return route(static::getBaseRoute().'.'.$route, $params);
    }

    protected static function setInstanceModel($model)
    {
        static::$allInstanceModels[static::class] = $model;
    }

    public static function getInstanceModel()
    {
        return static::$allInstanceModels[static::class] ?? null;
    }

    protected static function routeTo($uri)
    {
        $class = static::class;
        $datatableUri = $uri.'.datatable';
        Route::any(
            $uri.'/datatable',
            [
                'as' => $datatableUri,
                'uses'=> $class.'@datatable'
            ]
        );
        Route::resource($uri, $class);
    }

    public function model()
    {
        return app(static::$model)->with(static::getWith());
    }

    public function title()
    {
        return $this->title;
    }

    public function __call($func, $args)
    {
        if (static::getInstanceModel() && method_exists(static::getInstanceModel(), $func)) {
            return call_user_func_array([static::getInstanceModel(), $func], $args);
        }
        throw new BadMethodCallException("Call to undefined method ".static::class.":".$func.'()');
    }

    public function __get($prop)
    {
        if (static::getInstanceModel() && property_exists(static::getInstanceModel(), $prop)) {
            return (static::getInstanceModel())->{$prop};
        }
        throw new Exception("Undefined property ".static::class.":".$prop);
    }

    abstract public function fields(Request $request);
}
