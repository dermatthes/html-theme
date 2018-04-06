<?php
/**
 * Created by PhpStorm.
 * User: matthes
 * Date: 06.04.18
 * Time: 16:20
 */

return [
    "class" => "navbar-light bg-primary",
    "title" => "Some Title",
    "titleImg" => \HtmlTheme\Helper\DataUrl::FromFile(__DIR__ . "/bootstrap-solid.svg"),
    "titleHref" => "#",

    "navi" => [
        [
            "icon" => null,
            "name" => "First element",
            "href" => "#",
            "children" => null
        ],
        [
            "icon" => null,
            "name" => "Second",
            "href" => "#",
            "children" => [
                [
                    "name" => "First",
                    "href" => "#"
                ],
                [
                    "name" => "Second",
                    "href" => "#"
                ],
                [
                    "type" => "divider"
                ],
                [
                    "name" => "James Last",
                    "href" => "#"
                ]
            ]
        ]
    ]
];