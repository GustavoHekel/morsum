<?php

namespace Core;

class View
{
    /**
     * Render a view template using Twig
     *
     * @param string $template
     * @param array $args
     *
     * @return void
     */
    public static function view($template, $args = [])
    {
        static $twig = null;

        if ($twig === null) {
            $loader = new \Twig_Loader_Filesystem('../App/Views');
            $twig = new \Twig_Environment($loader);
        }

        echo $twig->render($template, $args);
    }
}
