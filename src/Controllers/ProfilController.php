<?php

namespace App\Controllers;

// dépendances Symfony
use App\Models\Voter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class ProfilController
{
    public function execute(Request $request, Session $session)
    {

        $response = new Response();

        $method = strtolower($request->getMethod());

        $view = '';
        $data = [];

        if ($method === "get" || $method === "post") {

            ob_start();
            require __DIR__ . '/../views/profil.php';
            $content = ob_get_clean();

            ob_start();
            require DEFAUT_TEMPLATE;
            $view = ob_get_clean();

            $response->setStatusCode(Response::HTTP_OK);
        }

        if ($method === "post") {

            // on récupère les paramètres du POST
            $erreurs = [];

            // Vérification du voter_id
            if ($request->request->has("voter_id")) {
                $voter_id = trim(strtolower($request->request->get("voter_id")));
                if (empty($voter_id)) {
                    array_push($erreurs, "Le paramètre [ID] est vide");
                }
            } else {
                array_push($erreurs, "Le paramètre [ID] est manquant");
            }

            // gestion des différentes erreurs
            if (count($erreurs) > 0) {
                $data = array("erreurs" => $erreurs);

                $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            } else {
                // On créer un objet Voter et on procède à l'authentification
                $voter = new Voter();
                $voter->setVoterId($voter_id);
                $voter->genererVoterKey();

                if ($voter->updateKey()) {
                    $data = array("success" => [$voter->getVoterKey()]);
                } else {

                    $data = array("erreurs" => ["impossible de mettre à jour la clé"]);
                }
            }
        }

        ob_start();
        require __DIR__ . '/../views/profil.php';
        $content = ob_get_clean();

        ob_start();
        require DEFAUT_TEMPLATE;
        $view = ob_get_clean();

        $response->setContent($view);
        $response->send();
    }
}
