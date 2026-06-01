<?php

use MyTour\Kernel;

require_once dirname(__DIR__) . '/vendor/autoload_runtime.php';

header('X-Replica: ' . gethostname());

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
