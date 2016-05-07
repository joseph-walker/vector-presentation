<?php

namespace Vector\Themes\Primer;

use Vector\Control\Functor;
use Vector\Core\Module;
use Vector\Markup\Html;
use Vector\TableBuilder\Presenter\PresenterInterface;
use Vector\Util;

class PrimerTablePresenter extends Module implements PresenterInterface
{
    private $tableProps;

    public function __construct($tableProps = [])
    {
        $this->tableProps = array_merge([
            'class' => 'vector_primer_table',
            'style' => 'display: flex;flex-direction: column;'
        ], $tableProps);
    }

    public function build($columnDefinitions, $data)
    {
        $node = Html::using('node');

        $table = $node('div');

        $makeHead = self::using('makeHead');
        $makeBody = self::using('makeBody');
        $makeStyle = self::using('makeStyle');
        $makeDownloadButton = self::using('makeDownloadButton');

        return $makeStyle() . $table($this->tableProps, [
            $makeDownloadButton(),
            $makeHead($columnDefinitions),
            $makeBody($columnDefinitions, $data)
        ]);
    }

    protected static function makeDownloadButton()
    {
        $text = Html::using('text');
        $node = Html::using('node');

        $button_row = $node('div');
        $a = $node('a');

        return $button_row([], [$a([
            'href' => Util::withQuery(['download' => 'csv']),
            'style' => 'margin-bottom: 5px;',
            'class' => 'btn btn-default right'
        ], [$text('Download CSV')])]);
    }

    protected static function makeHeadCell($column)
    {
        $text = Html::using('text');
        $node = Html::using('node');

        $th = $node('div');

        return $th(array_merge([
            'class' => 'vector_primer_table_head_cell',
        ], $column['props']), [$text($column['name'])]);
    }

    protected static function makeHead($columns)
    {
        $map = Functor::using('fmap');
        $node = Html::using('node');
        $makeHeadCell = self::using('makeHeadCell');

        $thead = $node('div');
        $tr = $node('div');

        return $thead([], [
            $tr([
                'class' => 'vector_primer_table_head',
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
            'class' => 'vector_primer_table_body_cell',
        ], $column['props']), [$text($column['accessor']($datum))]);
    }

    protected static function makeBodyRow($columns, $datum)
    {
        $map = Functor::using('fmap');
        $node = Html::using('node');
        $makeBodyCell = self::using('makeBodyCell');

        $tr = $node('div');

        return $tr([
            'class' => 'vector_primer_table_body_row',
            'style' => 'display: flex;'
        ], $map($makeBodyCell($datum), $columns));
    }

    protected static function makeStyle()
    {
        ob_start(); ?>

        <style>
            body {
                padding: 15px;
            }
            .vector_primer_download_button {

            }
            .vector_primer_table {
                margin-bottom: 10px;
                border-top: 0;
                border-radius: 3px;
                color: #68777d;
            }
            .vector_primer_table_head {
                position: relative;
                padding: 6px;
                margin-bottom: -1px;
                line-height: 20px;
                color: #68777d;
                background-color: #eee;
                background-image: linear-gradient(#fcfcfc, #eee);
                border: 1px solid #d5d5d5;
                border-top-left-radius: 3px;
                border-top-right-radius: 3px;
            }
            .vector_primer_table_body {
                border: 1px solid #ddd;
            }
            .vector_primer_table_head_row {
                padding: 6px 3px;
            }
            .vector_primer_table_head_cell {
                padding: 5px;
                flex: 1;
            }
            .vector_primer_table_body_cell {
                padding: 5px;
                flex: 1;
            }
            .vector_primer_table_body_row:nth-child(even) {
                background: #F5F5F5;
            }
            .vector_primer_table_body_row {
                padding: 5px;
                align-items: center;
            }
        </style>

        <?php return ob_get_clean();
    }

    protected static function makeBody($columns, $data)
    {
        $map = Functor::using('fmap');
        $node = Html::using('node');
        $makeBodyRow = self::using('makeBodyRow');

        $tbody = $node('div');

        return $tbody([
            'class' => 'vector_primer_table_body',
            'style' => 'display: flex;flex-direction: column;'
        ], $map($makeBodyRow($columns), $data));
    }
}

