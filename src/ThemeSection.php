<?php
/**
 * Created by PhpStorm.
 * User: matthes
 * Date: 28.03.18
 * Time: 15:24
 */

namespace HtmlTheme;



use HtmlTheme\Fhtml\FHtml;

class ThemeSection
{

    private $content = [];

    private $parentTheme;

    public function __construct(Theme $parentTheme)
    {
        $this->parentTheme = $parentTheme;
    }


    public function theme() : Theme
    {
        return $this->parentTheme;
    }

    public function section($name) : ThemeSection
    {
        return $this->parentTheme->section($name);
    }


    public function add ($html) : self
    {
        if ($this->content === null)
            $this->content = "";
        $this->content[] = $html;
        return $this;
    }



    public function fhtml(...$params) : FHtml
    {
        $this->content[] = $ret = new FHtml();
        return $ret->elem(...$params);
    }



    public function isEmpty() : bool
    {
        return $this->content === null;
    }


    public function getContent()
    {
        return implode("\n", $this->content);
    }


}