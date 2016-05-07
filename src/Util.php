<?php

namespace Vector;

class Util
{
    public static function withQuery(array $query) {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) . '?' . http_build_query(array_merge($_GET, $query));
    }
}


