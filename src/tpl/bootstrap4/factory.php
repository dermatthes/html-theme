<?php
/**
 * Created by PhpStorm.
 * User: matthes
 * Date: 28.03.18
 * Time: 12:34
 */


define ("B4D", __DIR__ . "/../_global/bootstrap-4.0.0-dist/");

return new \HtmlTheme\Theme(
    file_get_contents(__DIR__ . "/main.html"),
    [
        "title" => "Untitled document",
        "sec" => [
            "css" => file_get_contents(B4D . "css/bootstrap.min.css") .
                file_get_contents(B4D . "css/bootstrap-reboot.min.css") .
                file_get_contents(B4D . "css/bootstrap-grid.min.css"),
            "js"  => file_get_contents(B4D . "js/bootstrap.bundle.js")
        ]
    ],
    ["body"],
    ["title", "author", "keywords"]
);