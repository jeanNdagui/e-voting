<?php

namespace App\Controllers;

use App\Models\Voter;
// dépendances Symfony
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class LoginController
{
    public function execute( Request $request, Session $session)
    {

        $response = new Response();

        $method = strtolower($request->getMethod());

        $view = '';
        $data = [];

        if ($method === "get") {
            // Demande de la page de connection
            ob_start();
            require __DIR__ . '/../views/login.php';
            $content = ob_get_clean();

            ob_start();
            require DEFAUT_TEMPLATE;
            $view = ob_get_clean();
            $response->setStatusCode(Response::HTTP_OK);
        }

        if ($method === "post") { 
            // Authentification
            // on récupère les paramètres du POST
            $erreurs = [];

            // Vérification du login
            if ($request->request->has("voter_id")) {
                $voter_id = trim(strtolower($request->request->get("voter_id")));
                if (empty($voter_id)) {
                    array_push($erreurs, "Le paramètre [ID] est vide");
                }
            } else {
                array_push($erreurs, "Le paramètre [ID] est manquant");
            }

            // Vérification du password
            if ($request->request->has("password")) {
                $password = trim($request->request->get("password"));
                if (empty($password)) {
                    array_push($erreurs, "Le paramètre [password] est vide");
                }
            } else {
                array_push($erreurs, "Le paramètre [password] est manquant");
            }

            // gestion des différentes erreurs
            if (count($erreurs) > 0) {
                $data = array("erreurs" => $erreurs);
                ob_start();
                require __DIR__ . '/../views/login.php';
                $content = ob_get_clean();

                ob_start();
                require DEFAUT_TEMPLATE;
                $view = ob_get_clean();

                $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            } else {
                // On créer un objet Voter et on procède à l'authentification
                $voter = new Voter();
                $voter->setVoterId($voter_id);
                $voter->setPassword($password);
               
                if ($voter->login()) {
                
                    header('Location: profil');
                    return;
                } else {
                    
                    $data = array("erreurs" => ["login ou mot de passe incorrect"]);
                    
                    ob_start();
                    require __DIR__ . '/../views/login.php';
                    $content = ob_get_clean();

                    ob_start();
                    require DEFAUT_TEMPLATE;
                    $view = ob_get_clean();

                }
            }
        }

        $response->setContent($view);
        $response->send();
    }
}