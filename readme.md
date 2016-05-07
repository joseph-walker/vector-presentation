# Vector-Presentation

## Installation
```
composer require joseph-walker/vector-presentation
```

## Basic Presenters

### Table
> An html table (amaze right)

### Csv
> Yes, csv

### Json
> Yes, json

## Themes
> [Primer](http://primercss.io/)
> - https://cdn.jsdelivr.net/primer/3.0.1/primer.css

## FAQ

### Can I use this with illuminate/pagination and illuminate/database?

> Of course!

- put this in your bootstrap
```
Setup::eloquentPagination();
```

- then go to town!
```php
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
```
