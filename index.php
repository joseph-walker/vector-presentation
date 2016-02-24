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
// <table><thead><tr><th class="pull-left">Field A</th><th>Field B</th></tr></thead><tbody><tr><td class="pull-left">Hello</td><td>World</td></tr><tr><td class="pull-left">Foo</td><td>Bar</td></tr></tbody></table>

// CSV Table
$builder->setTablePresenter(new Presenter\CsvPresenter());
print_r($builder->build($data)); echo PHP_EOL;
// Field A,Field B\nHello,World\nFoo,Bar

// JSON Table
$builder->setTablePresenter(new Presenter\JsonPresenter());
print_r($builder->build($data)); echo PHP_EOL;
// [{"Field A":"Hello","Field B":"World"},{"Field A":"Foo","Field B":"Bar"}]
