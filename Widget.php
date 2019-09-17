<?php

namespace denis303\codeigniter4;

use Exception;

abstract class Widget
{

    protected $viewPath;

    protected $saveData = false;

    abstract function run();

    public function getViewPath()
    {
        $return = $this->viewPath;

        if (!$return)
        {
            $class = get_called_class();

            $segments = explode($class, "\\");

            array_pop($segments);

            if (count($segments) > 0)
            {
                $return = implode("\\", $segments);
            }
            else
            {
                throw new Exception('Property "viewPath" is not defined.');
            }
        }

        return $return;
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

        return view($template, $params, ['saveData' => $this->saveData]);
    }

}