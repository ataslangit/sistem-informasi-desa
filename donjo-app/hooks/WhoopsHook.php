<?php

class WhoopsHook
{
    public function bootWhoops()
    {
        if (ENVIRONMENT === 'development') {
            $whoops = new \Whoops\Run();
            $whoops->pushHandler(new Whoops\Handler\PrettyPageHandler());
            $whoops->register();
        }
    }
}
