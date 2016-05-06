<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<style>
    body {
        padding: 15px;
    }

    .vector_flex_table {
        border: 1px solid rgba(128, 128, 128, 0.5);
        border-radius: 3px;
        overflow: hidden;
        padding: 5px;
    }
    .vector_flex_table_head {
        padding: 5px;
    }
    .vector_flex_table_head_row {
        padding: 5px;
    }
    .vector_flex_table_head_cell {
        padding: 5px;
    }
    .vector_flex_table_body_cell {
        padding: 5px;
    }
    .vector_flex_table_body_row {
        padding: 5px;
    }
</style>

<?php

require_once 'bootstrap.php';

use Vector\TableBuilder\Builder;
use Vector\TableBuilder\Presenter\FlexTablePresenter;

/** @var \Illuminate\Pagination\Paginator $paginator */
$paginator = User::orderBy('id')->paginate(5);

$builder = new Builder(new FlexTablePresenter());

$builder
    ->column('Name', [], function($a) { return $a['name']; })
    ->column('Email', [], function($b) { return $b['email']; });

echo $builder->build($paginator->getCollection()->toArray());

echo $paginator->appends($_GET)->render();
