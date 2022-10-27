<?php

namespace App\Models;

use App\Database\Database;

class Admin
{
  private $login;
  private $password;
  private $session;

  public function __construct(string $login, string $password)
  {
    $this->login = $login;
    $this->password = $password;
  }

  public function login(): bool
  {
    $db = new Database();
    $result = $db->adminLogin();
 
    for ($i = 0; $i < count($result); $i++) {
      if (
        $result[$i]["login"] === strtolower($this->login)  &&
        $result[$i]["password"] === hash("sha256", $this->password)
      ) {
        return true;
      }
    }

    return false;
  }

}
