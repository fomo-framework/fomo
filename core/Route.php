<?php

namespace Core;

use Core\Response;

class Route
{
    protected array $routes = [];

    protected string $currentGroupPrefix = '';

    protected string $currentGroupNamespace = '';

    protected array $currentGroupMiddleware = [];

    protected string $namespace = 'App\Controller\\';

    public function post(string $route , string|array $callback): void
    {
        $this->addRoute('POST' , $route , $callback);
    }

    public function get(string $route , string|array $callback): void
    {
        $this->addRoute('GET' , $route , $callback);
    }

    public function patch(string $route , string|array $callback): void
    {
        $this->addRoute('PATCH' , $route , $callback);
    }

    public function put(string $route , string|array $callback): void
    {
        $this->addRoute('PUT' , $route , $callback);
    }

    public function delete(string $route , string|array $callback): void
    {
        $this->addRoute('DELETE' , $route , $callback);
    }

    public function group(array $parameters, callable $callback): void
    {
        $previousGroupNamespace = $this->currentGroupNamespace;
        if (isset($parameters['namespace']))
            $this->currentGroupNamespace = $previousGroupNamespace . $parameters['namespace'] . '\\';

        $previousGroupPrefix = $this->currentGroupPrefix;
        if (isset($parameters['prefix']))
            $this->currentGroupPrefix = $previousGroupPrefix . $parameters['prefix'] . '/';

        $previousGroupMiddleware = $this->currentGroupMiddleware;
        if (isset($parameters['middleware']))
            array_push($this->currentGroupMiddleware , $parameters['middleware']);

        $callback(Route::class);

        $this->currentGroupNamespace = $previousGroupNamespace;
        $this->currentGroupPrefix = $previousGroupPrefix;
        $this->currentGroupMiddleware = $previousGroupMiddleware;
    }

    protected function addRoute(string $method , string $route , string|array $callback): void
    {
        $route = $this->currentGroupPrefix . $route;

        $route = preg_replace('/^\//','' , $route);

        $route = preg_replace('/\/\//' , '' , $route);

        $route = preg_replace('/\//' , '\\/' , $route);

        $route = preg_replace('/\{([a-zA-Z]+)\}/' , '(?<\1>[a-z0-9-]+)' , $route);

        $route = '/^\/' . $route . '\/?$/i';

        if ($this->currentGroupNamespace != '')
            $routeParameters['namespace'] = $this->currentGroupNamespace;


        $routeParameters['method'] = $method;
        if (is_string($callback))
            list($routeParameters['controller'] , $routeParameters['action']) = explode('@' , $callback);
        else{
            list($routeParameters['controller'] , $routeParameters['action']) = explode('@' , $callback['uses']);

            if (isset($callback['middleware']))
                if (is_string($callback['middleware']))
                    $routeParameters['middleware'][0] = $callback['middleware'];
                else
                    $routeParameters['middleware'] = $callback['middleware'];
        }

        if (! isset($routeParameters['middleware']))
            $routeParameters['middleware'] = [];

        if (! empty($this->currentGroupMiddleware[0]))
            if (is_array($routeParameters['middleware']))
                $routeParameters['middleware'] = array_merge($routeParameters['middleware'] , is_array($this->currentGroupMiddleware[0]) ? $this->currentGroupMiddleware[0] : $this->currentGroupMiddleware);
            else
                $this->currentGroupMiddleware[0] != null ? array_push($routeParameters['middleware'] , is_array($this->currentGroupMiddleware[0]) ? $this->currentGroupMiddleware[0] : $this->currentGroupMiddleware) : null;

        $this->routes[$route] = $routeParameters;
    }

    protected function checkMatchRoute(string $url): bool|string
    {
        foreach ($this->routes as $route => $parameters) {
            if(preg_match($route , $url , $matches)) {
                foreach ($matches as $key => $match) {
                    if(is_string($key)) {
                        $this->routes[$route]['params'][$key] = $match;
                    }
                }
                return $route;
            }
        }
        return false;
    }

    protected function checkMatchMethod(string $route , string $method): bool
    {
        if ($this->routes[$route]['method'] == $method)
            return true;

        return false;
    }

    protected function checkExistController(string $route): bool|string
    {
        key_exists('namespace' , $this->routes[$route]) ? $namespace = $this->routes[$route]['namespace'] : $namespace = null;

        $controller = $this->routes[$route]['controller'];
        $controller = $this->namespace . $namespace . $controller;

        if (method_exists($controller , $this->routes[$route]['action']))
            return $controller;

        return false;
    }

    protected function checkExistAndAccessMiddleware(string $route): bool|Response
    {
        $middlewares = $this->routes[$route]['middleware'];
        foreach ($middlewares as $middleware){
            if (! method_exists($middleware , 'handle')){
                return json([
                    'message' => "middleware $middleware or method handle not exist"
                ] , 404);
            }

            $middleware = new $middleware();
            $callMiddleware = $middleware->handle();
            if ($callMiddleware !== true)
                return $callMiddleware;
        }
        return true;
    }

    protected function removeVariablesOfQueryString(string $route): bool|string
    {
        $parameters = explode('?' , $route);

        if (!str_contains($parameters[0], '='))
            return $parameters[0];

        return false;
    }


    public function dispatch(string $route , string $method)
    {
        $route = $this->removeVariablesOfQueryString($route);

        if ($route === false)
            return json([
                'message' => 'error'
            ] , 400);


        $checkMatch = $this->checkMatchRoute($route);
        if ($checkMatch === false)
            return json([
                'message' => 'not found'
            ] , 404);

        $checkMethod = $this->checkMatchMethod($checkMatch , $method);
        if ($checkMethod === false)
            return json([
                'message' => 'this is route not supported this method'
            ] , 405);


        $checkController = $this->checkExistController($checkMatch);
        if ($checkController === false)
            return json([
                'message' => 'controller or method not found'
            ] , 404);


        if (! empty($this->routes[$checkMatch]['middleware']))
            $checkMiddleware = $this->checkExistAndAccessMiddleware($checkMatch);

        if (isset($checkMiddleware) && $checkMiddleware !== true){
            return $checkMiddleware;
        }

        $controller = new $checkController();
        $method = $this->routes[$checkMatch]['action'];
        return call_user_func_array([$controller , $method] , $this->routes[$checkMatch]['params'] ?? []);
    }
}
