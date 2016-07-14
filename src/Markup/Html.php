<?php

namespace Vector\Markup;

use Vector\Core\Module;

use Vector\Lib\Strings;
use Vector\Lib\ArrayList;

class Html extends Module
{
    private static function attributes($attributes)
    {
        $attrVal = function($attr, $val) {
            return $attr . '="' . $val . '"';
        };

        return count($attributes)
            ? ' ' . Strings::join(' ', ArrayList::zipWith($attrVal, ArrayList::keys($attributes), ArrayList::values($attributes)))
            : '';
    }

    private static function children($children)
    {
        return Strings::join('', $children);
    }

    protected static function __node($node, $attributes, $children)
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

    protected static function __text($str)
    {
        return $str;
    }
}
