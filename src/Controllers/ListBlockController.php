<?php

namespace App\Controllers;

use App\Blockchain\Block;

// dépendances Symfony
use App\Models\Candidate;
use App\Database\Database;
use App\Blockchain\Blockchain;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class ListBlockController
{
    public function execute(Request $request, Session $session)
    {

        $listBlock = new Blockchain();

        $response = new Response();

        $results = [];

        $db = new Database();
        $blocks = $db->getBlockchain();

        if (is_array($blocks) && count($blocks) > 0) {
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

            if ($listBlock->isBlockChainValid()) {
                $listCandidate = Candidate::listCandidate();

                for ($i = 0; $i < count($listCandidate); $i++) {
                    $el_id = $listCandidate[$i]["candidate_id"];
                    $el_name = $listCandidate[$i]["candidate_name"];
                    $el_party = $listCandidate[$i]["candidate_party"];
                    $v = 0;

                    for ($j = 0; $j < count($listBlock->getBlocks()); $j++) {
                        $b = $listBlock->getBlocks()[$j];

                        if (strtolower($el_id) === strtolower($b->getData())) {
                            $v++;
                        }
                    }

                    array_push($results, [
                        "candidate_id" => $el_id,
                        "name" => $el_name, "party" => $el_party, "nb_cast" => $v
                    ]);
                }
            }
        }

        ob_start();
        require __DIR__ . '/../views/result.php';
        $content = ob_get_clean();

        ob_start();
        require DEFAUT_TEMPLATE;
        $view = ob_get_clean();

        $response->setStatusCode(Response::HTTP_OK);
        $response->setContent($view);
        $response->send();

        /*$method = strtolower($request->getMethod()); 
        $erreur = $request->query->count() != 0;

        if ($erreur) {
            // on note l'erreur
            $message = "Impossible de recupérer la blockchain";
            // retour résultat au contrôleur principal
            return [Response::HTTP_BAD_REQUEST, ["message" =>  $message ]];
        }
                
        $db = new Database(); 
        $result = $db->getBlockchain();
        return [Response::HTTP_OK, $result];*/
    }
}
