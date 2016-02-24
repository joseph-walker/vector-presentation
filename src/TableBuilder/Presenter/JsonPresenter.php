<?php

namespace Vector\TableBuilder\Presenter;

class JsonPresenter implements PresenterInterface
{
    public function build($columnDefinitions, $data)
    {
        $buffer = [];

        foreach ($data as $datum) {
            $row = &$buffer[];

            foreach ($columnDefinitions as $definition) {
                $row[$definition['name']] = $definition['accessor']($datum);
            }
        }

        return json_encode($buffer);
    }
}
