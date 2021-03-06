<?php

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/userguide3/general/hooks.html
|
*/
$hook['pre_system'] = [
    'class'    => 'Router',
    'function' => 'route',
    'filename' => 'router.php',
    'filepath' => 'hooks',
];
