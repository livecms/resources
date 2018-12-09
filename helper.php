<?php

if (! function_exists('ResAction')) {
    function ResAction()
    {
        $action = null;
        if ($route = app('request')->route()) {
            $action = $route->getAction();
        }
        return $action;
    }
}

if (! function_exists('ResController')) {
    function ResController()
    {
        $controller = null;
        if ($action = ResAction()) {
            $controller = $action['controller'];
            list($controller, $action) = explode('@', $controller);
        }

        return $controller;
    }
}

if (! function_exists('ResAttribute')) {
    function ResAttribute($attr, $default = null)
    {
        $controller = ResController();
        return $controller::${$attr} ?? $default;
    }
}

if (! function_exists('ResBaseRoute')) {
    function ResBaseRoute()
    {
        $parts = explode('.', ResAction()['as']);
        array_pop($parts);
        return implode('.', $parts);
    }
}

if (! function_exists('ResRoute')) {
    function ResRoute($route, array $params = [])
    {
        return route(ResBaseRoute().'.'.$route, $params);
    }
}

if (! function_exists('ResModel')) {
    function ResModel()
    {
        $controller = ResController();
        return $controller::getInstanceModel();
    }
}

if (! function_exists('ResTitle')) {
    function ResTitle()
    {
        $model = ResModel();
        $title = ResController()::getTitleField();
        return $model->{$title} ?? ResController()::getCaption();
    }
}

if (! function_exists('ResValidationJS')) {

    function ResValidationJS() {
        return <<<JS
        $.notify({
            icon: "ti-na",
            message: validation_title

        },{
            type: 'danger',
            timer: 10000,
            placement: {
                from: 'top',
                align: 'center'
            }
        });

        $('#resource_form').each(function () {
            var form = $(this);
            var validator = form.data('validation');
            var identifier = form.data('identifier');
            if (validator && identifier == validation_identifier) {
                Object.keys(form_errors).map(function(key, value) {
                    var input = form.find('label[for='+key+']').first().html();
                    value = form_errors[key].join(' ');
                    value = value.replace(input, '<span class="underline">'+input+'</span>');
                    form_errors[key] = value;
                });
                $(this).data('validation').showErrors(form_errors);
            }
        });
JS;
    }
}
