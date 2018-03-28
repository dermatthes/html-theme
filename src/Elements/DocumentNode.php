<?php
/**
 * Created by PhpStorm.
 * User: matthes
 * Date: 28.03.18
 * Time: 18:27
 */

namespace HtmlTheme\Elements;


class DocumentNode extends HtmlContainerElement
{
    use ParentNodeTrait;

    public function getParent(): HtmlContainerElement
    {
        return $this;
    }

    public function __construct()
    {
        parent::__construct("", []);
    }

    public function render($indent = "  ", $index = 0): string
    {
        $ret = "";
        foreach ($this->children as $curChild)
            $ret .= $curChild->render($indent, $index);
        return $ret;
    }

}