<?php

require 'vendor/autoload.php';

use App\Blockchain\Blockchain;
use App\Database\Database;
use App\Router;
// dépendances Symfony
use Symfony\Component\HttpFoundation\Session\Session;

// constantes globales
define('DIFFICULTY', 3);
define("DEFAUT_TEMPLATE",  __DIR__ . '/src/views/layouts/default.php');

$session = new Session();
$session->start();

$db = new Database();
$blocks = $db->getBlockchain();


if( count($blocks) == 0){
    $b = new Blockchain(DIFFICULTY); 
    $e = $b->getBlocks()[0];
    $db->addBlock($e->getIndex(),$e->getHash(),0,"",$e->getTime());
}

$router = new Router(__DIR__ . '/src');

$router
    ->get('/', 'Controllers/HomeController')
    ->get('/admin', 'Controllers/AdminController')
    ->post('/admin', 'Controllers/AdminController')
    ->get('/error', 'Controllers/ErrorController')
    ->get('/add_candidate', 'Controllers/AddCandidateController')
    ->post('/add_candidate', 'Controllers/AddCandidateController')
    ->get('/deconnection', 'Controllers/SignOutController')
    ->get('/login', 'Controllers/LoginController')
    ->post('/login', 'Controllers/LoginController')
    ->get('/create_user', 'Controllers/CreateUserController')
    ->post('/create_user', 'Controllers/CreateUserController')
    ->get('/profil', 'Controllers/ProfilController')
    ->post('/profil', 'Controllers/ProfilController')
    ->get('/cast', 'Controllers/CastController')
    ->post('/cast', 'Controllers/CastController')
    ->get('/candidate_list', 'Controllers/ListCandidateController')
    ->get('/voter_list', 'Controllers/ListVoterController')
    ->get('/result', 'Controllers/ListBlockController')
    ->run();
