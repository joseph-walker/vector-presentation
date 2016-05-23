<?php

namespace Vector\TableBuilder\Presenter;

use Vector\Core\Module;
use Vector\Control\Functor;
use Vector\Markup\Html;

class TablePresenter extends Module implements PresenterInterface
{
    private $tableProps;

    protected $dirtyHackToEnableIDEAutocompletion = true;

    public function __construct($tableProps = [])
    {
        $this->tableProps = $tableProps;
    }

    public function build($columnDefinitions, $data, $extra = null)
    {
        return Html::node('table', $this->tableProps, [
            self::makeHead($columnDefinitions),
            self::makeBody($columnDefinitions, $data)
        ]);
    }

    protected static function _makeHeadCell($column)
    {
        return Html::node('th', $column['props'], [Html::text($column['name'])]);
    }

    protected static function _makeHead($columns)
    {
        return Html::node('thead', [], [
            Html::node('tr', [], Functor::fmap(self::makeHeadCell(), $columns))
        ]);
    }

    protected static function _makeBodyCell($datum, $column)
    {
        return Html::node('td', $column['props'], [Html::text($column['accessor']($datum))]);
    }

    protected static function _makeBodyRow($columns, $datum)
    {
        return Html::node('tr', [], Functor::fmap(self::makeBodyCell($datum), $columns));
    }

    protected static function _makeBody($columns, $data)
    {
        return Html::node('tbody', [], Functor::fmap(self::makeBodyRow($columns), $data));
    }
}
