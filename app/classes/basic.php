<?php

function abort($code, $msg)
{
    http_response_code($code);
    echo $code . ' ' . $msg;
    exit;
}

function redirect($url)
{
    header('Location: ' . $url);
    exit;
}
