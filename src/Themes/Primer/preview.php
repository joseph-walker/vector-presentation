<?php

require_once __DIR__ . '/../../../bootstrap.php';

use Vector\TableBuilder\Builder;
use Vector\TableBuilder\Presenter\CsvPresenter;
use Vector\Themes\Primer\PrimerPagination;
use Vector\Themes\Primer\PrimerTablePresenter;

if (isset($_GET['download'])) {
    $builder = new Builder(new CsvPresenter());

    $builder
        ->column('Name', [], function($a) { return $a['name']; })
        ->column('Email', [], function($b) { return $b['email']; });

    echo $builder->build(User::orderBy('id')->get()->toArray());
    exit;
}

/** @var \Illuminate\Pagination\LengthAwarePaginator $paginator */
$paginator = User::orderBy('id')->paginate(5);

$builder = new Builder(new PrimerTablePresenter());

$button = "<button class='btn btn-primary'>asdf asd f</button>";

$builder
    ->column('Name', [], function($a) use ($button) { return $button; })
    ->column('Email', [], function($b) { return $b['email']; });

?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/primer/3.0.1/primer.css">

<?= $builder->build($paginator->getCollection()->toArray()) ?>

<?= PrimerPagination::render($paginator->appends($_GET)) ?>
