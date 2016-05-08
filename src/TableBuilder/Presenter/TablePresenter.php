<?php

namespace Vector\TableBuilder\Presenter;

use Vector\Core\Module;
use Vector\Control\Functor;
use Vector\Markup\Html;

class TablePresenter extends Module implements PresenterInterface
{
    private $tableProps;

    public function __construct($tableProps = [])
    {
        $this->tableProps = $tableProps;
    }

    public function build($columnDefinitions, $data, $extra = null)
    {
        $node = Html::using('node');

        $table = $node('table');

        $makeHead = self::using('makeHead');
        $makeBody = self::using('makeBody');

        return $table($this->tableProps, [
            $makeHead($columnDefinitions),
            $makeBody($columnDefinitions, $data)
        ]);
    }

    protected static function makeHeadCell($column)
    {
        $text = Html::using('text');
        $node = Html::using('node');

        $th = $node('th');

        return $th($column['props'], [$text($column['name'])]);
    }

    protected static function makeHead($columns)
    {
        $map          = Functor::using('fmap');
        $node         = Html::using('node');
        $makeHeadCell = self::using('makeHeadCell');

        $thead = $node('thead');
        $tr    = $node('tr');

        return $thead([], [
            $tr([], $map($makeHeadCell, $columns))
        ]);
    }

    protected static function makeBodyCell($datum, $column)
    {
        $text = Html::using('text');
        $node = Html::using('node');

        $td = $node('td');

        return $td($column['props'], [$text($column['accessor']($datum))]);
    }

    protected static function makeBodyRow($columns, $datum)
    {
        $map          = Functor::using('fmap');
        $node         = Html::using('node');
        $makeBodyCell = self::using('makeBodyCell');

        $tr = $node('tr');

        return $tr([], $map($makeBodyCell($datum), $columns));
    }

    protected static function makeBody($columns, $data)
    {
        $map         = Functor::using('fmap');
        $node        = Html::using('node');
        $makeBodyRow = self::using('makeBodyRow');

        $tbody = $node('tbody');

        return $tbody([], $map($makeBodyRow($columns), $data));
    }
}
