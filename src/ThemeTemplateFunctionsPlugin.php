<?php
/**
 * Created by PhpStorm.
 * User: matthes
 * Date: 28.03.18
 * Time: 15:09
 */

namespace HtmlTheme;


use Leuffen\TextTemplate\TextTemplate;
use Leuffen\TextTemplate\TextTemplatePlugin;

class ThemeTemplateFunctionsPlugin implements TextTemplatePlugin
{


    public function filterCompactJs ($input)
    {
        // Remove single Lines escaped by //
        $input = preg_replace("|([\n;})])\s*//.*|m", "\$1", $input);
        $input = preg_replace("|\s+|m", " ", $input);
        return $input;
    }

    public function fnSwitch($paramArr, $command, $context)
    {
        $defaults = "";
        if (isset ($paramArr["default"]))
            $defaults = $paramArr["default"];

        if (!isset ($paramArr["src"]) || $paramArr["src"] == null)
            return $defaults;
        return $paramArr["src"];
    }

    public function registerPlugin(TextTemplate $textTemplate)
    {
        $textTemplate->addFilter("compactJs", [$this, "filterCompactJs"]);
        $textTemplate->addFunction("switch", [$this, "fnSwitch"]);
    }



}