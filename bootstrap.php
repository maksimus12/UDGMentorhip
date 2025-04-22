<?php

use Core\Container;
use Core\Database;
use Core\App;


$container = new Container;

$container->bind('Core\Database', function () {

    $config = require base_path('config.php');
    return new Database($config['database'], $config['db_user'], $config['db_pass']);

});

$modelsPath = base_path('Http/models');
$files = scandir($modelsPath);
$models = array_diff($files, ['..', '.', 'BasicModel.php']);
foreach ($models as $model)
{
    $modelClass = 'Http\models\\' . pathinfo($model, PATHINFO_FILENAME);
    $container->bind($modelClass, function () use ($container, $modelClass)
    {
        return new $modelClass($container->resolve('Core\Database'));
    });
}

App::setContainer($container);
