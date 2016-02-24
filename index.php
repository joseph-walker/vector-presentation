<?php

use Vector\TableBuilder\Builder;
use Vector\TableBuilder\Presenter;

require __DIR__ . '/vendor/autoload.php';

$builder = new Builder(new Presenter\TablePresenter());

$builder
    ->column('Field A', ['class' => 'pull-left'], function($a) { return $a['a']; })
    ->column('Field B', [], function($b) { return $b['b']; });

$data = [
    ['a' => 'Hello', 'b' => 'World'],
    ['a' => 'Foo', 'b' => 'Bar']
];

// HTML Table
print_r($builder->build($data)); echo PHP_EOL;

// CSV Table
$builder->setTablePresenter(new Presenter\CsvPresenter());
print_r($builder->build($data)); echo PHP_EOL;

// JSON Table
$builder->setTablePresenter(new Presenter\JsonPresenter());
print_r($builder->build($data)); echo PHP_EOL;
