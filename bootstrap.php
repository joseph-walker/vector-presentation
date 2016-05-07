<?php

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Events\Dispatcher;
use Vector\Setup;

call_user_func(function () {
    $capsule = new Manager();
    $capsule->addConnection([
        'driver'    => 'mysql',
        'host'      => 'localhost',
        'database'  => 'homestead',
        'username'  => 'root',
        'password'  => 'root',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
    ]);
    $capsule->setEventDispatcher(new Dispatcher(new Container));
    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    class User extends Eloquent
    {
        protected $table = 'users';
    }
});

Setup::eloquentPagination();
