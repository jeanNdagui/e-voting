<?php

namespace App\Controllers;

// dépendances Symfony
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class SignOutController
{

    public function execute(Request $request, Session $session)
    {
        $session = new Session();

        $method = strtolower($request->getMethod());

        if ($method === "get") {
           
            if ($session->has('admin_statut')) {
  
                $session->remove('admin_statut');
                header('location: admin');

            } elseif ($session->has('voter_statut')) {

                $session->remove('voter_statut');
                header('location: login');
            }
        }
    }
}
