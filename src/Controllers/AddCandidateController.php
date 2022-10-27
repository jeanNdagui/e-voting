<?php

namespace App\Controllers;

use App\Models\Candidate;
// dépendances Symfony
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class AddCandidateController
{
    public function execute(Request $request, Session $session)
    {

        $response = new Response();
        $session = new Session();

        $method = strtolower($request->getMethod());

        $view = '';
        $data = [];

        // L'administrateur doit être authentifié avant d'accéder à cette page
        if (!($session->has('admin_statut') && $session->get('admin_statut') === true)) {
            header('Location: admin');
            return;
        }

        if ($method === "get") {

            $response->setStatusCode(Response::HTTP_OK);
        }

        if ($method === "post") {

            // on récupère les paramètres du POST
            $erreurs = [];

            // Vérification du candidate_name
            if ($request->request->has("candidate_name")) {
                $candidate_name = trim(strtolower($request->request->get("candidate_name")));
                if (empty($candidate_name)) {
                    array_push($erreurs, "Le paramètre [nom] est vide");
                }
            } else {
                array_push($erreurs, "Le paramètre [nom] est manquant");
            }

            // Vérification du candidate_party
            if ($request->request->has("candidate_party")) {
                $candidate_party = trim(strtolower($request->request->get("candidate_party")));
                if (empty($candidate_party)) {
                    array_push($erreurs, "Le paramètre [parti] est vide");
                }
            } else {
                array_push($erreurs, "Le paramètre [parti] est manquant");
            }

            // gestion des différentes erreurs
            if (count($erreurs) > 0) {

                $data = array("erreurs" => $erreurs);

                $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            } else {
                // On créer un objet candidat
                $candidate = new Candidate($candidate_name, $candidate_party);

                if ($candidate->addCandidate()) {

                    $data = array("success" => ["Le candidat {$candidate_name} a été enregistré."]);
                } else {
                    $data = array("erreurs" => ["Le candidat {$candidate_name} a déjà été ajouté."]);
                }
            }
        }

        ob_start();
        require __DIR__ . '/../views/candidate.php';
        $content = ob_get_clean();

        ob_start();
        require DEFAUT_TEMPLATE;
        $view = ob_get_clean();

        $response->setContent($view);
        $response->send();
    }
}
