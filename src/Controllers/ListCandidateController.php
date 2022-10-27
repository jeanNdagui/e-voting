<?php

namespace App\Controllers;

use App\Models\Candidate;

// dépendances Symfony
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class ListCandidateController
{
    public function execute(Request $request, Session $session)
    {

        $response = new Response();

        $method = strtolower($request->getMethod());

        $view = '';
        $data = [];

        if ($method === "get" || $method === "post") {
  
            $data = Candidate::listCandidate();
            
            ob_start();
            require __DIR__ . '/../views/list_candidate.php';
            $content = ob_get_clean();

            ob_start();
            require DEFAUT_TEMPLATE;
            $view = ob_get_clean();

            $response->setStatusCode(Response::HTTP_OK);
            $response->setContent($view);
            $response->send();
        }



        /*  $method = strtolower($request->getMethod()); 
        $erreur = $method !== "get" || $request->query->count() != 0;

        if ($erreur) {
            // on note l'erreur
            $message = "Impossible de lister les candidats";
            // retour résultat au contrôleur principal
            return [Response::HTTP_BAD_REQUEST, ["message" =>  $message ]];
        }
                
        return Candidate::listCandidate();*/
    }
}
