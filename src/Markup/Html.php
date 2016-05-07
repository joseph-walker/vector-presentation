<?php

namespace Vector\Markup;

use Vector\Core\Module;

use Vector\Lib\Strings;
use Vector\Lib\ArrayList;

class Html extends Module
{
    private static function attributes($attributes)
    {
        $join = Strings::using('join');
        $zip  = ArrayList::using('zipWith');
        $keys = ArrayList::using('keys');
        $vals = ArrayList::using('values');

        $attrVal = function($attr, $val) {
            return $attr . '="' . $val . '"';
        };

        return count($attributes)
            ? ' ' . $join(' ', $zip($attrVal, $keys($attributes), $vals($attributes)))
            : '';
    }

    private static function children($children)
    {
        $join = Strings::using('join');

        return $join('', $children);
    }

    protected static function node($node, $attributes, $children)
    {
        return '<'
            . $node
            . self::attributes($attributes)
            . '>'
            . self::children($children)
            . '</'
            . $node
            . '>';
    }

    protected static function text($str)
    {
        return $str;
    }
}
