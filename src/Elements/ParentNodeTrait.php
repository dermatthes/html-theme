<?php
/**
 * Created by PhpStorm.
 * User: matthes
 * Date: 28.03.18
 * Time: 18:42
 */

namespace HtmlTheme\Elements;


trait ParentNodeTrait
{
    protected $parent = null;

    public function _setParent(HtmlContainerElement $parent)
    {
        $this->parent = $parent;
    }

    public function getParent(): HtmlContainerElement
    {
        return $this->parent;
    }
}