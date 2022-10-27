<?php

namespace App;

use AltoRouter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class Router
{
    /**
     * @var string 
     */
    private $path;

    /**
     * @var AltoRouter
     */
    private $router;

    public function __construct(string $path)
    {
        $this->path = $path;
        $this->router = new AltoRouter();

        $tab = explode(DIRECTORY_SEPARATOR, dirname(__DIR__));
        $index = array_key_last($tab);
        $basePath = "/".$tab[$index];
          
        $this->router->setBasePath("/tp-vote");
    }

    public function get(string $url, string $view, ?string $name = null): self
    {
        $this->router->map('GET', $url, $view, $name);

        return $this;
    }

    public function post(string $url, string $view, ?string $name = null): self
    {
        $this->router->map('POST', $url, $view, $name);

        return $this;
    }

    public function run(): self
    {
        $match = $this->router->match();
        $view = $match["target"];
        
        $request = Request::createFromGlobals();
        $session = new Session();
        
        if(!is_null($view)){
            $tab = explode(DIRECTORY_SEPARATOR,$view);
            $index = array_key_last($tab);
            $basePath = $tab[$index];
    
            $controller = 'App\Controllers\\'.$basePath;
    
            (new $controller())->execute($request, $session);
        }else{
            header('Location: error');
        }
        
        
        return $this;
    }
}
