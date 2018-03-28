<?php
/**
 * Created by PhpStorm.
 * User: matthes
 * Date: 28.03.18
 * Time: 16:41
 */

namespace HtmlTheme\Elements;


class HtmlElement implements HtmlElementNode
{
    use ParentNodeTrait;

    protected $tag;
    protected $attrs;

    public function __construct($tag, array $attrs)
    {
        $this->tag = $tag;
        $this->attrs = $attrs;
    }


    public function setAttrib ($name, array $values)
    {
        if (!isset ($this->attrs[$name]))
            $this->attrs[$name] = [];
        foreach ($values as $curVal)
            $this->attrs[$name][] = $curVal;
        return $this;
    }


    public function renderAttrs (array $attribs) : string
    {
        $ret = "";
        foreach ($attribs as $attrName => $value) {
            $ret .= " " . htmlspecialchars($attrName) . "=\"" . htmlspecialchars(implode(" ", $value)) . "\"";
        }
        return $ret;
    }


    public function render ($indent="  ", $index = 0) : string
    {
        $ii = str_repeat($indent, $index);
        return "\n{$ii}<{$this->tag}{$this->renderAttrs($this->attrs)}/>";
    }
}