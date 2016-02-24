<?php

namespace Vector\TableBuilder\Presenter;

interface PresenterInterface
{
    public function build($columnDefinitions, $data);
}
