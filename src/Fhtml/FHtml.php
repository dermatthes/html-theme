<?php
    /**
     * Created by PhpStorm.
     * User: matthes
     * Date: 18.08.16
     * Time: 11:44
     */

    namespace HtmlTheme\Fhtml;

    use HtmlTheme\Elements\DocumentNode;
    use HtmlTheme\Elements\HtmlContainerElement;
    use HtmlTheme\Elements\HtmlElement;
    use HtmlTheme\Elements\RawHtmlNode;
    use HtmlTheme\Elements\TextNode;
    use HtmlTheme\Theme;

    /**
     * Class FHtml
     * @package Html5\FHtml
     *
     * @method $this div(...$params)
     * @method $this input(...$params)
     * @method $this p(...$params)
     * @method $this b(...$params)
     * @method $this h1(...$params)
     * @method $this h2(...$params)
     * @method $this h3(...$params)
     * @method $this h4(...$params)
     * @method $this hr(...$params)
     *
     */
    class FHtml {

        /**
         * @var DocumentNode
         */
        private $documentNode;

        /**
         * @var HtmlContainerElement
         */
        private $curNode;

        private $jumpMarks = [];

        private $emptyTags = ["meta"=>true, "img"=>true, "br"=>true, "hr"=>true, "input"=>true, "link"=>true];

        /**
         * @var Theme
         */
        private $theme;

        public function __construct(Theme $theme) {
            $this->theme = $theme;
            $this->documentNode = new DocumentNode();
            $this->curNode = $this->documentNode;
        }

        public function __call($name, $arguments) : self
        {
            if (count ($arguments) === 0) {
                // Variant: ->div()
                return $this->elem("{$name}");
            } else if (is_array($arguments[0])) {
                // Variant: ->div(["@class=?", $className])
                $args = $arguments[0];
                $attrs = array_shift($args);
                return $this->elem("{$name} {$attrs}", ...$args);
            } else {
                // Variant: ->div("@class=?", $classname)
                $attrs = array_shift($arguments);
                return $this->elem("{$name} {$attrs}", ...$arguments);
            }
        }

        /**
         * Define the sub-Element of the current node
         *
         * Example
         *
         * $e->elem("div @class = a b c @name = some Name")
         *
         * @param $def
         * @return FHtml
         */
        public function elem($elemDef, ...$params) : self {
            if (is_string($elemDef)) {
                $arrayArgs = $params;
            } else if (is_array($elemDef)) {
                $elemDefArr = $elemDef;
                $elemDef = array_shift($elemDefArr);
                $arrayArgs = $elemDefArr;
            } else {
                throw new \InvalidArgumentException("Invalid string or array in input: elem(" . gettype($elemDef). ")");
            }

            if (strpos($elemDef, ">") !== false) {
                // Multi-Element
                $curElem = $this;
                foreach (explode(">", $elemDef) as $curDef) {
                    $curElem = $curElem->elem(trim ($curDef));
                }
                return $curElem;
            }

            $arr = explode("@", $elemDef);
            $tagName = trim(strtolower(array_shift($arr)));

            $attrs = [];
            $qmIndex = 0;
            foreach ($arr as $attdef) {
                if ($attdef === "")
                    continue;
                list ($key, $val) = explode("=", $attdef, 2);
                if ( ! isset ($val)) {
                    $attrs[trim ($key)] = [];
                    continue;
                }

                $val = trim ($val);
                if (isset ($arrayArgs)) {
                    if ($val == "?" && isset ($arrayArgs[$qmIndex])) {
                        $val = $arrayArgs[$qmIndex];
                        $qmIndex++;
                    }
                }
                $attrs[trim($key)][] = $val;
            }

            if (isset ($this->emptyTags[$tagName])) {
                $newNode = new HtmlElement($tagName, $attrs);
            } else {
                $newNode = new HtmlContainerElement($tagName, $attrs);
            }
            $this->curNode->add($newNode);
            return $this->cloneit($newNode);
        }

        /**
         * @param string $name
         * @param array  $data
         *
         * @return string
         */
        public function template(string $name, array $data = []) : self
        {
            $textTemplate = $this->theme->buildTextTemplate();
            $textTemplate->loadTemplate($this->theme->_getTemplate($name));
            $this->curNode->add(new RawHtmlNode($textTemplate->apply($data)));
            return $this;
        }

        private function cloneit ($curNode) : FHtml {
            $new = new self($this->theme);
            $new->jumpMarks =& $this->jumpMarks;
            $new->curNode = $curNode;
            $new->documentNode = $this->documentNode;
            return $new;
        }

        /**
         * Generate <select> options on the Fly
         *
         * <example>
         * fhtml("select @name=country1")->options(["at"=>"Austria", "de" => "Germany", "us" => "USA"], $_POST["country1"]);
         * </example>
         *
         * @param array $options
         * @param string|null $selected
         * @return FHtml
         */
        public function options(array $options, string $selected=null) : self {
            foreach ($options as $key => $value) {
                if ($selected == $key)
                    $this->elem("option @value=? @selected=selected", $key)->text($value)->end();
                else
                    $this->elem("option @value=?", $key);
            }
            return $this;
        }



        public function end() : self {
            if ($this->curNode->getParent() === $this->curNode)
                throw new \InvalidArgumentException("end(): Node is document node.");
            return $this->cloneit($this->curNode->getParent());
        }

        public function as($name) : self {
            $this->jumpMarks[$name] = $this->curNode;
            return $this;
        }

        public function goto($name) : self {
            if ( ! isset($this->jumpMarks[$name]))
                throw new \InvalidArgumentException("goto($name) undefined.");
            $this->jumpMarks[$name];
            return $this->cloneit($this->jumpMarks[$name]);
        }

        public function text($content) : self {
            $this->curNode->add(new TextNode($content));
            return $this;
        }


        public function root() : self {
            return $this->cloneit($this->documentNode);
        }

        public function getDocument() : DocumentNode {
            return $this->documentNode;
        }

        public function render() : string {
            return $this->documentNode->render("  ", 0);
        }

        public function __toString()
        {
            return $this->render();
        }

    }