<?php
/**
 * Created by PhpStorm.
 * User: matthes
 * Date: 28.03.18
 * Time: 16:41
 */

namespace HtmlTheme\Elements;


class HtmlContainerElement extends HtmlElement
{

    /**
     * @var HtmlElementNode[]
     */
    protected $children = [];

    public function add(HtmlElementNode $child)
    {
        $this->children[] = $child;
        $child->_setParent($this);
    }


    public function render($indent = "  ", $index=0): string
    {
        $ii = str_repeat($indent, $index);

        $block = "\n$ii<{$this->tag}{$this->renderAttrs($this->attrs)}>";
        if (count ($this->children) === 0)
            return $block . "</{$this->tag}>";

        foreach($this->children as $curChild)
            $block .= $curChild->render($indent, $index+1);
        $block .= "\n$ii</{$this->tag}>";
        return $block;
    }

}