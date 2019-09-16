<?php

namespace denis303\codeigniter4;

abstract class Widget
{

    protected $viewPath;

    abstract function run();

    public function getViewPath()
    {
        return $this->viewPath;
    }

    public function widget(array $params = [])
    {
        foreach($params as $key => $value)
        {
            $this->$key = $value;
        }

        return $this->run();
    }

    public function render($template, array $params = [])
    {
        if ($this->viewPath)
        {
            $template = $this->getViewPath() . "\\" . $template;
        }

        return view($template, $params, ['saveData' => false]);
    }

}