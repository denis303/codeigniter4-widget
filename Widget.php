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

            $segments = explode("\\", $class);

            array_pop($segments);

            if (count($segments) > 0)
            {
                $return = implode("\\", $segments);
            }
            else
            {
                throw new Exception('Undefined property: ' . $class . '::$viewPath');
            }
        }

        return $return;
    }

    public function setParams(array $params = [])
    {
        foreach($params as $key => $value)
        {
            $this->$key = $value;
        }
    }

    public static function factory(array $params = [])
    {
        return view_cell(get_called_class() . '::widget', $params);
    }

    public function widget(array $params = [])
    {
        $this->setParams($params);

        return $this->run();
    }

    protected function render($template, array $params = [])
    {
        $viewPath = $this->getViewPath();

        if ($viewPath)
        {
            $template = $viewPath . "\\" . $template;
        }

        return view($template, $params, ['saveData' => $this->saveData]);
    }

}