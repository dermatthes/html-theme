<?php
/**
 * Created by PhpStorm.
 * User: matthes
 * Date: 28.03.18
 * Time: 12:32
 */


namespace Test;

require __DIR__ . "/../vendor/autoload.php";

use HtmlTheme\ThemeFactory;

$theme = ThemeFactory::Load("bootstrap4");

$theme->section("body")->fhtml("section @class=container > div @class=py-5 text-center")
    ->h1()->text("Fehler")->end()
    ->p()->text("Dies ist das Ende");

echo $theme->renderToString();