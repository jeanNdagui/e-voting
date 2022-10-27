<?php

namespace App\Controllers;

use App\Models\Voter;
// dépendances Symfony
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class CreateUserController
{
    public function execute(Request $request, Session $session)
    {

        $response = new Response();
        $session = new Session();

        $method = strtolower($request->getMethod());

        $view = '';
        $data = [];

        if ($method === "get") {

            $response->setStatusCode(Response::HTTP_OK);
        }

        if ($method === "post") {

            // on récupère les paramètres du POST
            $erreurs = [];

            // Vérification du username
            if ($request->request->has("username")) {
                $username = trim(strtolower($request->request->get("username")));
                if (empty($username)) {
                    array_push($erreurs, "Le paramètre [username] est vide");
                }
            } else {
                array_push($erreurs, "Le paramètre [username] est manquant");
            }

            // Vérification du cni
            if ($request->request->has("cni")) {
                $cni = trim(strtolower($request->request->get("cni")));
                if (empty($cni)) {
                    array_push($erreurs, "Le paramètre [cni] est vide");
                }elseif(strlen($cni) !== 9 && is_numeric($cni)) {
                    array_push($erreurs, "Le paramètre [cni] doit avoir 9 chiffres");
                }
            } else {
                array_push($erreurs, "Le paramètre [cni] est manquant");
            }

            // Vérification du contact_no
            if ($request->request->has("contact_no")) {
                $contact_no = trim(strtolower($request->request->get("contact_no")));
                if (empty($contact_no)) {
                    array_push($erreurs, "Le paramètre [mobile] est vide");
                }elseif(strlen($contact_no) !== 9 && is_numeric($contact_no)) {
                    array_push($erreurs, "Le paramètre [mobile] doit avoir 9 chiffres");
                }
            } else {
                array_push($erreurs, "Le paramètre [mobile] est manquant");
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

                $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            } else {
                // On crée un objet voter
                $voter = new Voter($password, $username, $cni, $contact_no);

                if ($voter->create_user()) {

                    $data = array("success" => ["Votre clé pour voter est: <span class=\"fw-bold\"> {$voter->getVoterKey()} </span> </br>Maintenant vous pouvez vous connecter et voter en utilisant l'identifiant: <span class=\"fw-bold text-uppercase\"> {$voter->getVoterId()} </span> ."]);
                } else {
                    $data = array("erreurs" => ["L'électeur {$username} a déjà été ajouté."]);
                }
            }
        }

        ob_start();
        require __DIR__ . '/../views/create_user.php';
        $content = ob_get_clean();

        ob_start();
        require DEFAUT_TEMPLATE;
        $view = ob_get_clean();

        $response->setContent($view);
        $response->send();

    }
}
