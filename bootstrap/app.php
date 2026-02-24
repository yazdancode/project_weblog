<?php

use System\Config\Env;
new \System\Application\Application();
function basePath($path = '')
{
    return __DIR__ . '/../' . $path;
}
Env::load(basePath('.env'));