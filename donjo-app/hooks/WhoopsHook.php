<?php

use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

class WhoopsHook
{
    public function bootWhoops()
    {
        if (ENVIRONMENT === 'development') {
            $run = new Run();
            $run->pushHandler(new PrettyPageHandler());
            $run->register();
        }
    }
}
