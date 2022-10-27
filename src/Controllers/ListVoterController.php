<?php

namespace App\Controllers;

use App\Models\Voter;

// dépendances Symfony
use App\Models\Candidate;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class ListVoterController
{
    public function execute( Request $request, Session $session)
    {                

        $response = new Response();

        $method = strtolower($request->getMethod());

        $view = '';
        $data = [];

        if ($method === "get" || $method === "post") {
  
            $data = Voter::listVoter();
            
            ob_start();
            require __DIR__ . '/../views/list_voter.php';
            $content = ob_get_clean();

            ob_start();
            require DEFAUT_TEMPLATE;
            $view = ob_get_clean();

            $response->setStatusCode(Response::HTTP_OK);
            $response->setContent($view);
            $response->send();
        }
        
    }
}