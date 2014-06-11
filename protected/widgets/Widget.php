<?php

class Widget extends CComponent
{
	private static $_widgets = array();

    /**
     * create a widget and register him by name.
     * @param string $class widget class name
     * @param string $name register widget name
     * @param array $properties set widget params
     * @param bool $captureOutput output type {true - print}
     * @return obj
     */
    public static function create($class, $name = null, $properties=array(),$captureOutput=false)
	{
        $controller = new Controller(null);
        $widget = $controller->widget($class, $properties, $captureOutput);
        if(!$name){
            $name = $class;
        }
		self::$_widgets[$name] = $widget;
        return $widget;
	}

    /**
     * geting widget object from registry
     * @param string $name registered name
     * @return obj or name
     */
    public static function get($name){
        if(array_key_exists($name, self::$_widgets)){
            return self::$_widgets[$name];
        } else {
			$class = ucfirst($name);
            return Widget::create($class, $name);
        }
    }
}