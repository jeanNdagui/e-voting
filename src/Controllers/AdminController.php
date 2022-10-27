<?php

namespace App\Controllers;

use App\Models\Admin;
// dépendances Symfony
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class AdminController
{

    public function execute(Request $request, Session $session)
    {
        $response = new Response();

        $method = strtolower($request->getMethod());

        $view = '';

        if ($method === "get") {
            // Demande de la page de connection
            ob_start();
            require __DIR__ . '/../views/admin.php';
            $content = ob_get_clean();

            ob_start();
            require DEFAUT_TEMPLATE;
            $view = ob_get_clean();
            echo "hello get";
            $response->setStatusCode(Response::HTTP_OK);
        }

        if ($method === "post") { 
            // Authentification
            // on récupère les paramètres du POST
            $erreurs = [];

            // Vérification du login
            if ($request->request->has("login")) {
                $login = trim(strtolower($request->request->get("login")));
                if (empty($login)) {
                    array_push($erreurs, "Le paramètre [login] est vide");
                }
            } else {
                array_push($erreurs, "Le paramètre [login] est manquant");
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
            if (count($erreurs) > 0) { var_dump($erreurs);
                $data = array("erreurs" => $erreurs);
                ob_start();
                require __DIR__ . '/../views/admin.php';
                $content = ob_get_clean();

                ob_start();
                require DEFAUT_TEMPLATE;
                $view = ob_get_clean();

                $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            } else {
                // On créer un objet admin
                $admin = new Admin($login, $password);
               
                if ($admin->login()) {
                    // L'admin est connecté
                    $session = new Session();                    
                    $session->set("admin_statut", true);

                    header('Location: add_candidate');
                    return;
                } else {
                    
                    $data = array("erreurs" => ["login ou mot de passe incorrect"]);
                    
                    ob_start();
                    require __DIR__ . '/../views/admin.php';
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
