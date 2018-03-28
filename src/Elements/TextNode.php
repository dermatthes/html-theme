<?php
/**
 * Created by PhpStorm.
 * User: matthes
 * Date: 28.03.18
 * Time: 16:48
 */

namespace HtmlTheme\Elements;


class TextNode implements HtmlElementNode
{
    use ParentNodeTrait;

    private $value;

    public function __construct($value = "")
    {
        $this->value = $value;
    }

    public function render($indent = "  ", $index = 0): string
    {
        return htmlentities($this->value);
    }
}