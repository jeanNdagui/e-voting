<?php

namespace App\Controllers;


use App\Models\Voter;
// dépendances Symfony
use App\Blockchain\Block;
use App\Models\Candidate;
use App\Database\Database;
use App\Blockchain\Blockchain;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class CastController
{
    public function execute(Request $request, Session $session)
    {

        $response = new Response();
        $session = new Session();

        $method = strtolower($request->getMethod());

        $view = '';
        $data = [];
        $erreurs = [];
        $success = [];

        // L'administrateur doit être authentifié avant d'accéder à cette page
        if (!($session->has('voter_statut') && $session->get('voter_statut') === true)) {
            header('Location: login');
            return;
        }

        $results = Candidate::listCandidate();

        (is_array($results)) ? $data = $results :
            array_push($erreurs, "Il n' y a pas encore de candidat pour se vote");
        $response->setStatusCode(Response::HTTP_OK);

        if ($method === "post") {

            // Vérification du candidate
            if ($request->request->has("candidate_id")) {
                $candidate_id = trim(strtolower($request->request->get("candidate_id")));
                if (empty($candidate_id)) {
                    array_push($erreurs, "Le paramètre [candidate] est vide");
                }
            } else {
                array_push($erreurs, "Le paramètre [candidate] est manquant");
            }

            // Vérification du voter_key
            if ($request->request->has("voter_key")) {
                $voter_key = trim(strtolower($request->request->get("voter_key")));
                if (empty($voter_key)) {
                    array_push($erreurs, "Le paramètre [clé] est vide");
                }
            } else {
                array_push($erreurs, "Le paramètre [clé] est manquant");
            }

            // gestion des différentes erreurs
            if (count($erreurs) > 0) {

                $response->setStatusCode(Response::HTTP_BAD_REQUEST);
            } else {
                // On créer un objet voter et on procède à la validation du vote
                $voter = new Voter();
                $voter->setVoterId($session->get('voter_info')[0]["voter_id"]);
                $voter->setVoterKey($voter_key);


                if ($voter->cast($candidate_id, 1)) {

                    $listBlock = new Blockchain();

                    $db = new Database();
                    $blocks = $db->getBlockchain();

                    if (is_null($blocks)) {
                        array_push($erreurs, "Impossible de valider votre vote");
                        $voter->cast($candidate_id, 0);
                    } elseif (is_array($blocks)) {

                        $bks = [];
                        for ($i = 0; $i < count($blocks); $i++) {
                            $b = $blocks[$i];
                            $block = new Block(
                                $b["index"],
                                $b["hash"],
                                $b["previousHash"],
                                $b["data"],
                                $b["timestamp"]
                            );
                            array_push($bks, $block);
                        }

                        $listBlock->difficulty = DIFFICULTY;
                        $listBlock->loadBlocks($bks);

                        $a = $listBlock->newBlock($candidate_id);
                        $listBlock->addBlock($a);

                        $db = new Database();
                        $result = $db->addBlock(
                            $a->getIndex(),
                            $a->getHash(),
                            $a->getPreviousHash(),
                            $a->getData(),
                            $a->getTime()
                        );
                        // var_dump($result);return;
                        if (!$result) {
                            array_push($erreurs, "Impossible de valider votre vote");
                        } else {
                            array_push($success, "Votre a été enregistré.");
                        }
                    }
                } else {

                    array_push($erreurs, "Vous avez déjà voté ou </br> 
                                 votre clé de vote est invalide.");
                }
            }
        }

        ob_start();
        require __DIR__ . '/../views/cast.php';
        $content = ob_get_clean();

        ob_start();
        require DEFAUT_TEMPLATE;
        $view = ob_get_clean();

        $response->setContent($view);
        $response->send();



        /* $method = strtolower($request->getMethod()); 
        $erreur = $method !== "post" || $request->query->count() != 0;

        if ($erreur) {
            // on note l'erreur
            $message = "Impossible de poursuivre le vote";
            // retour résultat au contrôleur principal
            return [Response::HTTP_BAD_REQUEST, ["message" =>  $message ]];
        }
                
        // on récupère les paramètres du POST
        $erreurs = [];

        // Vérification du vote_id  
        if($request->request->has("voter_id")){
            $voter_id = trim(strtolower($request->request->get("voter_id")));
        }else{
           array_push($erreurs ,"Le paramètre [voter_id] est manquant");
        }

        // Vérification de la clé
        if($request->request->has("voter_key")){
            $voter_key = trim($request->request->get("voter_key"));
        }else{
           array_push($erreurs ,"Le paramètre [voter_key] est manquant");
        }

         // Vérification de la candidate_id
         if($request->request->has("candidate_id")){
            $candidate_id = trim($request->request->get("candidate_id"));
        }else{
           array_push($erreurs ,"Le paramètre [candidate_id] est manquant");
        }

        // gestion des différentes erreurs
        if(count($erreurs) > 0){
            return [Response::HTTP_BAD_REQUEST, ["message" => $erreurs]];    
        }

       $voter = new Voter();
       $voter->setVoterId($voter_id);
       $voter->setVoterKey($voter_key);

       return $voter->cast($candidate_id, $v);
        */
    }
}
