<?php

use app\core\View;

function setSection($name)
{
    echo View::$sectionValues[$name];
}

function setValueSection($name, $value)
{
    View::$sectionValues[$name] = $value;
}

function method($method)
{
    echo '<input type="hidden" name="_method" value="' . $method . '">';
}