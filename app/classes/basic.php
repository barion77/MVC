<?php

function abort($code)
{
    http_response_code($code);
    $config = require_once '../config/app.php';
    exit($code . ' ' . $config[0]['status_codes'][$code]);
}

function redirect($url)
{
    header('Location: ' . $url);
    exit;
}
