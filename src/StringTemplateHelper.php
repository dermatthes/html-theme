<?php
/**
 * Created by PhpStorm.
 * User: matthes
 * Date: 28.03.18
 * Time: 14:05
 */

namespace HtmlTheme;


class StringTemplateHelper
{


    protected function replace (array $matches) : string
    {

    }

    protected function applyRow(string $text, array $data) : string
    {
        return preg_replace_callback("/\{\{()/i", function($matches){ return $this->replace($matches); }, $text);
    }


    public function apply ($input, array $data)
    {
        $rows = explode("\n", $input);
        for ($i=0; $i<count($rows); $i++) {
            $rows[$i] = $this->applyRow($rows[$i], $data);
        }
    }


}