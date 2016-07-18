<?php

namespace Vector\Themes\Primer;

use Illuminate\Pagination\LengthAwarePaginator;
use Vector\Control\Functor;
use Vector\Core\Module;
use Vector\Markup\Html;
use Vector\TableBuilder\Presenter\PresenterInterface;

/**
 * @method static orderByHeader($label, $name, $query, $up = 'up', $down = 'down') Create order by links and labels for column headers
 * @method static keys($arr) Return the keys of a list.
 */
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

    public static function __orderByHeader($label, $name, $query, $up = 'up', $down = 'down')
    {
        if (isset($query[$name]) && $query[$name] === 'asc') {
            $direction = $down;
            $link = '';
        } elseif (isset($query[$name]) && $query[$name] === 'desc') {
            $direction = $up;
            $link = 'asc';
        } else {
            $direction = '';
            $link = 'desc';
        }

        $queryString = http_build_query(array_merge($_GET, [
            $name => $link
        ]));

        ob_start(); ?>
        <a href="<?= $_SERVER['SCRIPT_NAME'] ?>?<?= $queryString ?>"><?= $label . ' ' . $direction ?></a>
        <?php return ob_get_clean();
    }

    public function build($columnDefinitions, $data, $extra = null)
    {
        $node = Html::using('node');

        $empty = function () {
            return '<div></div>';
        };

        if (isset($extra['paginator'])
            && get_class($extra['paginator']) === LengthAwarePaginator::class
        ) {
            /** @var LengthAwarePaginator $paginator */
            $paginator = $extra['paginator'];
            $makeResultCount = function () use ($paginator) {
                return 'Showing result '
                . ($paginator->firstItem() === $paginator->lastItem()
                    ? $paginator->firstItem()
                    : ($paginator->firstItem()
                        .  ' - '
                        . $paginator->lastItem()))
                . ' of '
                . $paginator->total();
            };
        } else {
            $makeResultCount = $empty;
        }

        $table = $node('div');

        $makeHead = self::using('makeHead');
        $makeBody = self::using('makeBody');
        $makeStyle = self::using('makeStyle');
        $makeDownloadButton = isset($extra['download']) && $extra['download']
            ? self::using('makeDownloadButton')
            : $empty;
        $makeButtonBar = self::using('makeButtonBar');
        $makePageLengthSelector = isset($extra['perPage']) && $extra['perPage']
            ? self::using('makePageLengthSelector')
            : $empty;

        return $makeStyle() . $makeButtonBar([
            $makePageLengthSelector(),
            $makeResultCount(),
            $makeDownloadButton()
        ]) . $table($this->tableProps, [
            $makeHead($columnDefinitions),
            $makeBody($columnDefinitions, $data)
        ]);
    }

    protected static function __makePageLengthSelector()
    {
        $node = Html::using('node');

        $select = $node('select');
        $option = $node('option');

        $perPageOption = function ($value) use ($option) {
            $value = htmlentities($value, ENT_QUOTES, 'UTF-8', false);

            return isset($_GET['perPage']) && $_GET['perPage'] == $value
                ? $option(['value' => $value, 'selected' => ''], ["$value per page"])
                : $option(['value' => $value], ["$value per page"]);
        };

        return $select([
            'class' => 'form-select',
            'onchange' => "window.location = window.location.search.indexOf('perPage') !== -1"
                . "? window.location.href.replace(/(perPage=)[^\&]+/, '$1' + this.value)"
                . ": (window.location.search == '' ? (window.location.href + '?perPage=' + this.value) : (window.location.href + '&perPage=' + this.value));"
        ], [
            $perPageOption(10),
            $perPageOption(25),
            $perPageOption(50),
            $perPageOption(100)
        ]);
    }

    protected static function __makeDownloadButton()
    {
        $text = Html::using('text');
        $node = Html::using('node');

        $a = $node('a');

        return $a([
            'download' => 'table.csv',
            'href' => parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
                . '?'
                . http_build_query(array_merge($_GET, ['download' => 'csv'])),
            'class' => 'btn btn-default'
        ], [$text('Download CSV')]);
    }

    protected static function __makebuttonBar(array $buttons)
    {
        $node = Html::using('node');

        $div = $node('div');

        return $div([
            'class' => 'vector_primer_table_button_bar',
            'style' => 'margin-bottom: 5px;',
        ], $buttons);
    }

    protected static function __makeHeadCell($column)
    {
        $text = Html::using('text');
        $node = Html::using('node');

        $th = $node('div');

        return $th(array_merge([
            'class' => 'vector_primer_table_head_cell',
        ], $column['props']), [$text($column['name'])]);
    }

    protected static function __makeHead($columns)
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

    protected static function __makeBodyCell($datum, $column)
    {
        $text = Html::using('text');
        $node = Html::using('node');

        $td = $node('div');

        return $td(array_merge([
            'class' => 'vector_primer_table_body_cell',
        ], $column['props']), [$text($column['accessor']($datum))]);
    }

    protected static function __makeBodyRow($columns, $datum)
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

    protected static function __makeStyle()
    {
        ob_start(); ?>

        <style>
            .vector_primer_table_button {
            }
            .vector_primer_table_button_bar {
                display: flex;
                justify-content: space-between;
                align-items: center;
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
                width: 0;
                word-break: break-all;
            }
            .vector_primer_table_body_cell {
                padding: 5px;
                flex: 1;
                width: 0;
                word-break: break-all;
            }
            .vector_primer_table_body_row {
                padding: 5px;
                align-items: center;
                background: white;
            }
            .vector_primer_table_body_row:nth-child(even) {
                background: #F5F5F5;
            }
        </style>

        <?php return ob_get_clean();
    }

    protected static function __makeBody($columns, $data)
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

