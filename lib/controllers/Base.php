<?php

abstract class Base
{
    protected $action;
    protected $template;
    protected $params;

    public function __construct($action = '')
    {
        $this->action = $action;
    }

    protected function inputSource()
    {
    }

    protected function outputSource()
    {
        echo $this->genTemplate(
            $this->template
        );
    }

    public function createPage()
    {
        $this->inputSource();
        $this->outputSource();
    }

    protected function genTemplate($fileName)
    {
        foreach ($this->params as $k => $v) {
            $$k = $v;
        }
        ob_start();
        include $fileName;
        return ob_get_clean();
    }
}