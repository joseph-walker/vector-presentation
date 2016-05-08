<?php

namespace Vector\TableBuilder;

use Vector\TableBuilder\Presenter\PresenterInterface as TablePresenter;

class Builder
{
    private $columnData;
    private $tablePresenter;

    public function __construct(TablePresenter $tablePresenter)
    {
        $this->columnData = [];
        $this->setTablePresenter($tablePresenter);

        return $this;
    }

    public function setTablePresenter(TablePresenter $tablePresenter)
    {
        $this->tablePresenter = $tablePresenter;

        return $this;
    }

    public function column($name, $columnProps, $accessorFunction)
    {
        $this->columnData[] = [
            'name'     => $name,
            'props'    => $columnProps,
            'accessor' => $accessorFunction
        ];

        return $this;
    }

    public function build($data, ...$extra)
    {
        return $this->tablePresenter->build($this->columnData, $data, $extra);
    }
}
