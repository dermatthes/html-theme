<?php
/**
 * Created by PhpStorm.
 * User: matthes
 * Date: 28.03.18
 * Time: 12:31
 */

namespace HtmlTheme;


class ThemeFactory
{

    const THEMES_AVAIL = [
        "bootstrap4" => __DIR__ . "/tpl/bootstrap4/factory.php"
    ];


    public static function Load($themeName) : Theme
    {
        if (!isset(self::THEMES_AVAIL[$themeName]))
            throw new \InvalidArgumentException("Theme '$themeName' not defined. Available themes: " . implode (", ", array_keys(self::THEMES_AVAIL)));
        return require self::THEMES_AVAIL[$themeName];
    }

}