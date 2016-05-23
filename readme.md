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
$paginator = User::orderBy('id')->paginate(isset($_GET['perPage']) ? $_GET['perPage'] : 10);

$builder = new Builder(new PrimerTablePresenter());

$button = "<button class='btn btn-primary'>asdf asd f</button>";

$builder
    ->column('Name', [], function($a) use ($button) { return $button; })
    ->column('Email', [], function($b) { return $b['email']; });
```

Poke
