<?php

namespace App\Models;

use App\Database\Database;
// dépendances Symfony
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class Candidate
{
  private $candidate_id;
  private $candidate_name;
  private $candidate_party;

  public function getCandidateId(){
    return $this->candidate_id;
  }

  public function getCandidateName(){
    return $this->candidate_name;
  }

  public function getCandidateParty(){
    return $this->candidate_party;
  }

  public function __construct(string $candidate_name, string $candidate_party)
  {
      $this->candidate_id = "CAN".random_int(10, 100);
      $this->candidate_name = $candidate_name;
      $this->candidate_party = $candidate_party;
  }

  public function addCandidate():bool
  {
    $db = new Database();
    return $db->addCandidate($this->candidate_id, $this->candidate_name, $this->candidate_party);
  }

  public static function listCandidate():?array
  {
    $db = new Database();
    $result = $db->listCandidate();
    
    if(is_null($result)){
        return null;
    }else{
        return $result;
    }
  }
  
}