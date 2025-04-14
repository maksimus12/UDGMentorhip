<?php

use Core\Container;
use Core\Database;
use Core\App;

$container = new Container;
App::setContainer($container);

$container->bind(Database::class, function () {
    $config = require base_path('config.php');

    return new Database($config['database'], $config['db_user'], $config['db_pass']);
});

// Bind the models to the container
$modelsPath = base_path('Http/Models');
$files = scandir($modelsPath);
//get all models from the models path
$models = array_diff($files, ['..', '.', 'BasicModel.php']);
foreach ($models as $model) {
    $modelClass = 'Http\\Models\\' . pathinfo($model, PATHINFO_FILENAME);
    $container->bind($modelClass, function () use ($modelClass) {
        return new $modelClass();
    });
}
