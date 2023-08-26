<?php

use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

class WhoopsHook
{
    public function bootWhoops()
    {
        if (ENVIRONMENT === 'development') {
            $whoops = new Run();
            $whoops->pushHandler(new PrettyPageHandler());
            $whoops->register();
        }
    }
}
