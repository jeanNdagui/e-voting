<?php

namespace App\Responses;

interface IResponse{
    public function sendResponse(array $content, int $tatus,array $headers):void;
}