<?php

require('../vendor/autoload.php');

$config = require(__DIR__ . '/../src/settings.php');

$app = new \Slim\App($config);

/** Register dependencies */
require __DIR__ . '/../src/dependencies.php';

/** Register routes */
require __DIR__ . '/../src/routes.php';

$app->run();
