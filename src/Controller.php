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
    protected static $allBaseRoutes = [];
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

    public static function register($baseRoute = '')
    {
        if (!property_exists(static::class, 'model')) {
            throw new Exception("Please define a model first", 1);
        }

        static::$allBaseRoutes[static::class] = $baseRoute;

        static::routeTo(static::getUri());
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
        return static::$allBaseRoutes[static::class];
    }

    public static function uri($uri = null)
    {
        if ($uri !== null) {
            return static::$uri = $uri;
        }
        if (!static::$uri) {
            static::register();
        }
        return static::$uri;
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
        $datatableUri = basename($uri).'.datatable';
        Route::any(
            $uri.'/datatable',
            [
                'as' => $datatableUri,
                'uses'=> $class.'@datatable'
            ]
        );
        Route::resource($uri, $class);
    }

    public static function route($uri = null, array $params = [])
    {
        $baseRoute = ltrim(rtrim(static::getBaseRoute(), '.').'.'.static::getUri(), '.');
        if ($uri == null) {
            return route($baseRoute, $params);
        }
        return route($baseRoute.'.'.$uri, $params);
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
