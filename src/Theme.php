<?php
/**
 * Created by PhpStorm.
 * User: matthes
 * Date: 28.03.18
 * Time: 12:28
 */

namespace HtmlTheme;


use Leuffen\TextTemplate\TextTemplate;
use Psr\Http\Message\ResponseInterface;

class Theme
{

    private $mainTemplate;
    private $scope;
    /**
     * @var ThemeSection[]
     */
    private $sections;
    private $placeholder;
    private $templates;

    public function __construct(string $mainTemplate, array $scope, array $sections, array $placeholder, array $templates, self $extends = null)
    {
        $this->mainTemplate = $mainTemplate;
        $this->scope = $scope;
        $this->templates = $templates;
        // Register sections
        foreach ($sections as $key => $value) {
            if (is_numeric($key)) {
                $this->sections[$value] = new ThemeSection($this);
                continue;
            }
            $this->sections[$key] = (new ThemeSection($this))->add($value);
        }
    }


    public function _getTemplate (string $name) : string
    {
        if ( ! isset ($this->templates[$name]))
            throw new \InvalidArgumentException("No template '$name' registered for this theme");
        return file_get_contents($this->templates[$name]);
    }



    public function section($name) : ThemeSection
    {
        if ( ! isset ($this->sections[$name]))
            throw new \InvalidArgumentException("Section '$name' undefined. Available sections: " . implode(", ", array_keys($this->sections)));
        if ( ! $this->sections[$name] instanceof ThemeSection)
            $this->sections[$name] = new ThemeSection($this);
        return $this->sections[$name];
    }


    public function buildTextTemplate () : TextTemplate
    {
        $textTemplate = new TextTemplate();
        $textTemplate->addPlugin(new ThemeTemplateFunctionsPlugin());
        return $textTemplate;
    }


    /**
     * @return string
     * @throws \Leuffen\TextTemplate\TemplateParsingException
     */
    public function renderToString () : string
    {
        $scope = $this->scope;
        if ( ! is_array($scope["sec"]))
            $scope["sec"] = [];

        foreach ($this->sections as $name => $val) {
            $scope["sec"][$name] = $val->getContent();
        }

        $textTemplate = $this->buildTextTemplate();
        $textTemplate->loadTemplate($this->mainTemplate);
        return $textTemplate->apply($scope, false);
    }

    /**
     * @param ResponseInterface $response
     *
     * @return ResponseInterface
     * @throws \Leuffen\TextTemplate\TemplateParsingException
     */
    public function renderToResult (ResponseInterface $response)
    {
        $response->getBody()->write($this->renderToString());
        return $response;
    }


}