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

$theme->section("body")
    ->fhtml("div @class=container")
        ->h1()->text("Navbars")->end()
        ->p("@class=lead")->text("Welcome to the wonderful world of templates")->end()

        ->h2()->text("Top navbar from template")->end()
        ->template("navbar", require __DIR__ . "/navbar.ser.php")

        ->h2()->text("Top navbar programmatic")->end()
        ->elem("nav @class=navbar navbar-expand-lg navbar-light bg-light")
            ->elem("a @class=navbar-brand href=#")->text("HtmlTheme")->end()
            ->elem("a @class=")->end()
        ->end()

        ->h2()->text("Alert")->end()
        ->p()->text("")->end()
        ->elem("div @class=alert alert-success")
            ->h4("@class=alert-heading")->text("Fehler")->end()
            ->hr()->end()
            ->p("@class=mb0")->text("Dies ist das Ende");

echo $theme->renderToString();