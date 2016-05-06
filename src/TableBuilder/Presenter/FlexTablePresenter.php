<?php

namespace Vector\TableBuilder\Presenter;

use Vector\Core\Module;
use Vector\Control\Functor;
use Vector\Markup\Html;

class FlexTablePresenter extends Module implements PresenterInterface
{
    private $tableProps;

    public function __construct($tableProps = [])
    {
        $this->tableProps = array_merge([
            'class' => 'vector_flex_table',
            'style' => 'display: flex;flex-direction: column;'
        ], $tableProps);
    }

    public function build($columnDefinitions, $data)
    {
        $node = Html::using('node');

        $table = $node('div');

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

        $th = $node('div');

        return $th(array_merge([
            'class' => 'vector_flex_table_head_cell',
        ], $column['props']), [$text($column['name'])]);
    }

    protected static function makeHead($columns)
    {
        $map          = Functor::using('fmap');
        $node         = Html::using('node');
        $makeHeadCell = self::using('makeHeadCell');

        $thead = $node('div');
        $tr    = $node('div');

        return $thead([], [
            $tr([
                'class' => 'vector_flex_table_head',
                'style' => 'display: flex;'
            ], $map($makeHeadCell, $columns))
        ]);
    }

    protected static function makeBodyCell($datum, $column)
    {
        $text = Html::using('text');
        $node = Html::using('node');

        $td = $node('div');

        return $td(array_merge([
            'class' => 'vector_flex_table_body_cell',
        ], $column['props']), [$text($column['accessor']($datum))]);
    }

    protected static function makeBodyRow($columns, $datum)
    {
        $map          = Functor::using('fmap');
        $node         = Html::using('node');
        $makeBodyCell = self::using('makeBodyCell');

        $tr = $node('div');

        return $tr([
            'class' => 'vector_flex_table_body_row',
            'style' => 'display: flex;'
        ], $map($makeBodyCell($datum), $columns));
    }

    protected static function makeBody($columns, $data)
    {
        $map         = Functor::using('fmap');
        $node        = Html::using('node');
        $makeBodyRow = self::using('makeBodyRow');

        $tbody = $node('div');

        return $tbody([
            'class' => 'vector_flex_table_body',
            'style' => 'display: flex;flex-direction: column;'
        ], $map($makeBodyRow($columns), $data));
    }
}
