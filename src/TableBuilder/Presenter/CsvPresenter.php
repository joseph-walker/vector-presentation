<?php

namespace Vector\TableBuilder\Presenter;

use Vector\Lib\Lambda;
use Vector\Lib\Strings;
use Vector\Control\Functor;
use Vector\Control\Lens;

class CsvPresenter implements PresenterInterface
{
    public function build($columnDefinitions, $data)
    {
        $view      = Lens::using('view');
        $indexLens = Lens::using('indexLens');
        $compose   = Lambda::using('compose');
        $fmap      = Functor::using('fmap');
        $join      = Strings::using('join');

        $buffer   = [];
        $buffer[] = $fmap($view($indexLens('name')), $columnDefinitions);

        foreach ($data as $datum) {
            $row = &$buffer[];

            foreach ($columnDefinitions as $definition) {
                $row[] = $definition['accessor']($datum);
            }
        }

        $csvBuilder = $compose($join(PHP_EOL), $fmap($join(',')));

        return $csvBuilder($buffer);
    }
}
