<?php

namespace App\Controllers;

use App\Models\Admin;
use App\Models\Voter;
use App\Blockchain\Block;
use App\Models\Candidate;
// dépendances Symfony
use App\Database\Database;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class BlockController 
{
    public function execute(Request $request, Session $session, Block $b)
    {

        $method = strtolower($request->getMethod());
        $erreur =  $request->query->count() != 0; 
        
        if ($erreur) {
            // on note l'erreur
            $message = "Impossible de valider le vote";
            // retour résultat au contrôleur principal
            return [Response::HTTP_BAD_REQUEST, ["message" =>  $message]];
        }
        
       if(!is_null($b)){
        $db = new Database();
        $result = $db->addBlock($b->getIndex(), $b->getHash(), $b->getPreviousHash(), $b->getData(), $b->getTime());
        var_dump($result);
        if (is_bool($result) && $result) { return [Response::HTTP_OK, ["message" => "Vote validé"]];
            
          } else {
            return [Response::HTTP_NOT_FOUND, ["message" => "Impossible de valider le vote"]];
          }
       }
    }
}
