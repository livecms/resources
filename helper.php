<?php

if (! function_exists('ResController')) {
    function ResController()
    {
        $controller = app('request')->route()->getAction()['controller'];
        list($controller, $action) = explode('@', $controller);
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

if (! function_exists('ResRoute')) {
    function ResRoute($route, array $params = [])
    {
        $controller = ResController();
        return $controller::route($route, $params);
    }
}

if (! function_exists('ResModel')) {
    function ResModel()
    {
        $controller = ResController();
        return $controller::$instanceModel;
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
