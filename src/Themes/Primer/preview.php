<?php

require_once __DIR__ . '/../../../bootstrap.php';

use Vector\TableBuilder\Builder;
use Vector\TableBuilder\Presenter\CsvPresenter;
use Vector\Themes\Primer\PrimerPagination;
use Vector\Themes\Primer\PrimerTablePresenter;

$orderByName = function (\Illuminate\Database\Eloquent\Builder $query, $queryString) {
    if (isset($queryString['name']) && in_array($queryString['name'], ['desc', 'asc'])) {
        $query->orderBy('name', $queryString['name']);
    }

    return $query;
};
$q = User::whereNotNull('id');
$query = $orderByName($q, $_GET);

if (isset($_GET['download'])) {
    $builder = new Builder(new CsvPresenter());

    $builder
        ->column('Name', [], function($a) { return $a['name']; })
        ->column('Email', [], function($b) { return $b['email']; });

    echo $builder->build($query->toArray());
    exit;
}

/** @var \Illuminate\Pagination\LengthAwarePaginator $paginator */
$paginator = $query->paginate(isset($_GET['perPage']) ? $_GET['perPage'] : 10);

$builder = new Builder(new PrimerTablePresenter());

$builder
    ->column(
        PrimerTablePresenter::orderByHeader('Name', 'name', $_GET, 'up', 'down'),
        [],
        function ($a) {
            return $a['name'];
        }
    )
    ->column('Email', [], function($b) { return $b['email']; });

?>

<html>
    <head>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/primer/3.0.1/primer.css">
    </head>
    <body>
    <?= $builder->build($paginator->getCollection()->toArray(), [
        'paginator' => $paginator,
        'perPage' => true,
        'download' => true,
        'sortable' => true
    ]) ?>

    <?= PrimerPagination::render($paginator->appends($_GET)) ?>
    </body>
</html>


