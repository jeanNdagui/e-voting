<?php

namespace App\Models;

use App\Database\Database;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class Voter
{
  private $voter_id;
  private $username;
  private $cni;
  private $voted;
  private $contact_no;
  private $password;
  private $voter_key;
  private $session;

  public function getVoterKey(): string
  {
    return $this->voter_key;
  }

  public function genererVoterKey():void
  {
    $this->voter_key = hash("md5", $this->username . $this->cni . $this->contact_no. uniqid()); 
  }

  public function setVoterKey(string $key): void
  {
    $this->voter_key = $key;
  }

  public function getVoterId(): string
  {
    return $this->voter_id ;
  }

  public function setVoterId(string $voter_id): void
  {
    $this->voter_id = $voter_id;
  }

  public function setPassword(string $pwd): void
  {
    $this->password = $pwd;
  }

  public function __construct(string $password = null, string $username = null, string $cni = null, string $contact_no = null)
  {
    $this->voter_id = strtolower("vot" . random_int(10, 10000));
    $this->username = $username;
    $this->cni = $cni;
    $this->voted = 0;
    $this->contact_no = $contact_no;
    $this->password = $password;
    $this->voter_key = hash("md5", $username . $cni . $contact_no);
    $this->session = new Session();
  }

  public function updateKey():bool
  {
    $db = new Database();
    return $db->updateKey($this->voter_id, $this->voter_key);
  }

  public function create_user(): bool
  {

    $db = new Database();
    return $db->create_user($this->password, $this->voter_id, $this->username, $this->voted, $this->cni, $this->contact_no, $this->voter_key);
  }

  public static function listVoter(): ?array
  {
    $db = new Database();
    $result = $db->listVoter();

    if (is_null($result)) {
      return null;
    } else {
      return $result;
    }
  }

  public function login(): bool
  {
    $db = new Database();
    $result = $db->loginVote();

    for ($i = 0; $i < count($result); $i++) {

      if (
        $result[$i]["voter_id"] === strtolower($this->voter_id) &&
        $result[$i]["password"] === hash("sha256", $this->password)
      ) {
        // L'électeur est connecté
        $this->session->set("voter_statut", true);
        $this->session->set("voter_info",[0 => ["voter_id" => $result[$i]["voter_id"], "username" => $result[$i]["username"], "cni" => $result[$i]["cni"], "contact_no" => $result[$i]["contact_no"], "voter_key" => $result[$i]["voter_key"]]]);
        return true;
      }
    }

    return false;
  }

  public function cast(string $candidate_id, int $v)
  {
    $db = new Database();
    $result = null;

    if ($this->checkCast($this->voter_id)) {
      return false;
    } else {
      if(!$this->checkCast($this->voter_id) && $v == 1){
        $result = $db->castVote($this->voter_id, $this->voter_key, $v);
      }
    }

    if ($result) {
      return true;
    } else {
     return false;
    }
  }

  public function checkCast($voter_id): bool
  {
    $db = new Database();
    return $db->checkCast($this->voter_id);
  }
}
