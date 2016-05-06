# Vector-Presentation

## Purpose
> Quickly turning data into another form for either UI/UX or consumption by another source. Intended for use with "table-like" data.

## Installation
```
composer require joseph-walker/vector-presentation
```

## Supported Presenters

### Table
> An html table (amaze right)

### Flex Table
> A table with inline Flex-box styles

### Csv
> Yes, csv

### Json
> Yes, json

## FAQ

### Can I use this with Eloquent collections?

> Of course!

```php
$paginator = User::orderBy('id')->paginate(5);

$builder = new Builder(new FlexTablePresenter());

$builder
    ->column('Name', [], function($a) { return $a['name']; })
    ->column('Email', [], function($b) { return $b['email']; });
    
echo $builder->build($paginator->getCollection()->toArray());

// then render your paginator, if you choose

echo $paginator->appends($_GET)->render();

```

### How do I setup a paginator outside Laravel?

> Yep! just put this in your bootstrap process!

```php
Paginator::currentPathResolver(function () {
    return isset($_SERVER['REQUEST_URI']) ? strtok($_SERVER['REQUEST_URI'], '?') : '/';
});

Paginator::currentPageResolver(function () use ($pageName) {
    $pageName = 'page';
    $page = isset($_REQUEST[$pageName]) ? $_REQUEST[$pageName] : 1;
    return $page;
});
```