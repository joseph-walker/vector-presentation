<?php

namespace Vector;

use Illuminate\Pagination\Paginator;

class Setup
{
    public static function eloquentPagination()
    {
        Paginator::currentPathResolver(function () {
            return isset($_SERVER['REQUEST_URI']) ? strtok($_SERVER['REQUEST_URI'], '?') : '/';
        });

        Paginator::currentPageResolver(function () {
            $pageName = 'page';
            $page = isset($_REQUEST[$pageName]) ? $_REQUEST[$pageName] : 1;
            return $page;
        });
    }
}
