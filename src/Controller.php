<?php

namespace LiveCMS\Resources;

use BadMethodCallException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use LiveCMS\DataTables\HasDataTables;

abstract class Controller implements HasDataTables
{
    use Resource;

    protected $request;

    public static $name;
    public static $caption;
    public static $title = 'name';
    public static $uri;
    public static $model;
    public static $instanceModel;
    public static $key = 'id';
    public static $with = [];
    public static $datatableURL;
    public static $baseRoute;
    public static $baseView;

    public function __construct()
    {
        $this->request = app('request');
        static::$model::observe($this);
    }

    public static function register()
    {
        static::$name
            = static::$name
                ?? Str::replaceLast('Resource', '', basename(
                        str_replace('\\', '//', static::$model)
                    ), '-');
        static::$caption = static::$caption ?? title_case(snake_case(static::$name, ' '));

        static::routeTo(static::$uri ?? Str::snake(static::$name, '-'));
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

    protected static function routeTo($uri)
    {
        $uri = static::uri($uri);
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
        $baseRoute = ltrim(rtrim(static::$baseRoute, '.').'.'.static::$uri, '.');
        if ($uri == null) {
            return route($baseRoute, $params);
        }
        return route($baseRoute.'.'.$uri, $params);
    }

    public function model()
    {
        return app(static::$model)->with(static::$with);
    }

    public function title()
    {
        return $this->title;
    }

    public function __call($func, $args)
    {
        if (static::$instanceModel && method_exists(static::$instanceModel, $func)) {
            return call_user_func_array([static::$instanceModel, $func], $args);
        }
        throw new BadMethodCallException("Call to undefined method ".static::class.":".$func.'()');
    }

    public function __get($prop)
    {
        if (static::$instanceModel && property_exists(static::$instanceModel, $prop)) {
            return (static::$instanceModel)->{$prop};
        }
        throw new Exception("Undefined property ".static::class.":".$prop);
    }

    abstract public function fields(Request $request);
}
