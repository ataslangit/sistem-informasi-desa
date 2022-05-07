<?php

class MY_loader extends CI_Loader
{
    public function view_theme($folder, $view, $vars = [], $return = false)
    {
        $this->_ci_view_paths = array_merge($this->_ci_view_paths, [THEMEPATH . $folder . '/' => true]);

        return $this->_ci_load([
            '_ci_view'   => $view,
            '_ci_vars'   => $this->_ci_prepare_view_vars($vars),
            '_ci_return' => $return,
        ]);
    }
}
