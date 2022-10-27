<?php

// respect strict des types déclarés des paramètres de foctions
declare(strict_types=1);

namespace App\Responses;

use Symfony\Component\HttpFoundation\Response;


class JsonResponse implements IResponse{ 

    public function sendResponse(array $content,int $tatus,array $headers):void{
       $response = new response();
       $response->setStatusCode($tatus);
       foreach ($headers as $text => $value) {
        $response->headers->set($text, $value);
      }
      $response->headers->set("content-type", "application/json");
       $response->setCharset("utf-8");

       $response->setContent(json_encode($content, JSON_UNESCAPED_UNICODE));
       $response->send();
      
    }
}
