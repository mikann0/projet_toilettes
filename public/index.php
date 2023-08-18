<?php

use App\Kernel;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {
    // @mika second argument is for debug.
    // if false: no debug
    // if true: debug
    return new Kernel($context['APP_ENV'], true);
};
