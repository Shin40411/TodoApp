<?php

/**
 * /application/core/MY_Loader.php
 *
 */
class TemplateLoader extends CI_Loader
{
    public function template($template_name, $vars = array(), $return = FALSE)
    {
        if ($return) :
            $content  = $this->view('layout/header', $vars, $return);
            $content .= $this->view($template_name, $vars, $return);
            $content .= $this->view('layout/footer', $vars, $return);

            return $content;
        else :
            $this->view('layout/header', $vars);
            $this->view($template_name, $vars);
            $this->view('layout/footer', $vars);
        endif;
    }
}