<?php

namespace Core;

class Router
{
    protected $routes = [];
    protected $params = [];

    /**
     * Add a new route as a regular expression
     *
     * @param string $route  URL
     * @param array  $params Parameters
     *
     * @return void
     */
    public function add($route, $params = [])
    {
        $route = preg_replace('/\//', '\\/', $route);
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);
        $route = '/^' . $route . '$/i';
        $this->routes[$route] = $params;
    }

    /**
     * Routes getter
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * Check if the route is defined with a regular expression
     * @param string $url
     * @return bool
     */
    public function match($url)
    {
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
                }

                $this->params = $params;
                return true;
            }
        }

        return false;
    }

    /**
     * Get the currently matched parameters
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Execute controller's method
     * @param string $url
     * @return void
     */
    public function dispatch($url)
    {
        $url = $this->removeQueryString($url);


        if ($this->match($url)) {
            $controller = $this->params['controller'];
            $controller = $this->parseName($controller);
            $controller = $this->addSufix($controller);
            $controller = $this->getNamespace() . $controller;

            if (class_exists($controller)) {
                $controller_object = new $controller($this->params);

                $method = $this->params['method'];
                $method = $this->convertToCamelCase($method);

                if (is_callable([$controller_object, $method])) {
                    $this->checkAditionalParameters();
                    call_user_func_array([$controller_object, $method], [$this->params['id']]);

                } else {
                    throw new \Exception('Method "' . $method . '" not found');
                }
            } else {
                throw new \Exception('Controller "' . $controller . '" not found');
            }
        } else {
            throw new \Exception('Route "' . $url . '" not found.', 404);
        }
    }

    /**
     * Set the id key on the params array to avoid error
     * @return null
     */
    public function checkAditionalParameters()
    {
        $this->params['id'] = isset ($this->params['id']) ? $this->params['id'] : null;
    }

    /**
     * Get the controller's name
     *
     * @param string $string
     * @return string
     */
    protected function parseName($string)
    {
        $string = str_replace('-', ' ', $string);
        $string = ucwords($string);
        $string = str_replace(' ', '', $string);
        return $string;
    }

    /**
     * Add "Controller" sufix
     * @param string $string
     * @return string
     */
    protected function addSufix($string)
    {
        return $string . 'Controller';
    }

    /**
     * Convert the string to camel case
     * @param string $string
     * @return string
     */
    protected function convertToCamelCase($string)
    {
        return ucfirst($this->parseName($string));
    }

    /**
     * Remove the query string
     * @param string $url
     * @return string
     */
    protected function removeQueryString($url)
    {
        if ($url != '') {
            $parts = explode('&', $url, 2);

            if (strpos($parts[0], '=') === false) {
                $url = $parts[0];
            } else {
                $url = '';
            }
        }

        return $url;
    }

    /**
     * Get the namespace for the controller.
     * @return string
     */
    protected function getNamespace()
    {
        $namespace = 'App\Controllers\\';

        if (array_key_exists('namespace', $this->params)) {
            $namespace .= $this->params['namespace'] . '\\';
        }

        return $namespace;
    }
}
