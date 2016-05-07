<link rel="stylesheet" href="https://cdn.jsdelivr.net/primer/3.0.1/primer.css">

<?php

require_once __DIR__ . '/../../../bootstrap.php';

use Vector\TableBuilder\Builder;
use Vector\Themes\Primer\PrimerPagination;
use Vector\Themes\Primer\PrimerTablePresenter;

/** @var \Illuminate\Pagination\LengthAwarePaginator $paginator */
$paginator = User::orderBy('id')->paginate(5);

$builder = new Builder(new PrimerTablePresenter());

$builder
    ->column('Name', [], function($a) { return $a['name']; })
    ->column('Email', [], function($b) { return $b['email']; });

echo $builder->build($paginator->getCollection()->toArray());

PrimerPagination::render($paginator->appends($_GET));
