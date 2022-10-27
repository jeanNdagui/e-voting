<?php

namespace App\Controllers;

use App\Database\Database;
use App\Models\Admin;
// dépendances Symfony
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class ErrorController
{

    public function execute(Request $request, Session $session)
    {
        $response = new Response();

        $method = strtolower($request->getMethod());
        
        if($method === "get"){
            $data = array("erreurs" => "Page non trouvée");

            ob_start();
            require __DIR__ . '/../views/error.php';
            $content = ob_get_clean();

            ob_start();
            require DEFAUT_TEMPLATE;
            $view = ob_get_clean();
        }
        $response->setStatusCode(Response::HTTP_NOT_FOUND);
        $response->setContent($view);
        $response->send();        
    }
}
