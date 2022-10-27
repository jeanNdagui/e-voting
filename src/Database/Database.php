<?php

namespace App\Database;

use Symfony\Component\HttpFoundation\Session\Session;

use PDO;

class Database
{
  private const HOTE = "mysql:host=localhost;dbname=tp_vote";
  private const USER = "root";
  private const PWD = "";
  private static $instance;

  public function __construct()
  {
  }

  public static function getConnection()
  {
    if (is_null(self::$instance)) {
      self::$instance = new PDO(self::HOTE, self::USER, self::PWD);
    }
    return self::$instance;
  }

  public function closeConnection()
  {
    self::$instance = null;
  }

  public function adminLogin()
  {
    try {
      $con = $this->getConnection();
      $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $stmt = $con->prepare("SELECT login, password FROM Admin ");
      $stmt->execute();
      $stmt->setFetchMode(PDO::FETCH_ASSOC);
      return ($stmt->fetchAll());
    } catch (\PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }
    $this->closeConnection();
    return null;
  }

  public function addCandidate(
    string $candidate_id,
    string $candidate_name,
    string $candidate_party
  ) {
    try {
      $con = $this->getConnection();
      $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $stmt = $con->prepare(
        "INSERT INTO Candidate (candidate_id, candidate_name, candidate_party)
                     VALUES (:candidate_id, :candidate_name, :candidate_party)"
      );

      $stmt->bindParam(':candidate_id', $candidate_id);
      $stmt->bindParam(':candidate_name', $candidate_name);
      $stmt->bindParam(':candidate_party', $candidate_party);

      $stmt->execute();

      return true;
    } catch (\PDOException $e) {
      //echo "Connection failed: " . $e->getMessage();
      return false;
    }
    $this->closeConnection();
    return false;
  }


  public function listCandidate():?array
  {
    try {
      $con = $this->getConnection();
      $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $stmt = $con->prepare("SELECT * FROM Candidate ");
      $stmt->execute();
      $stmt->setFetchMode(PDO::FETCH_ASSOC);
      return ($stmt->fetchAll());
    } catch (\PDOException $e) {
    //  echo "Connection failed: " . $e->getMessage();
    return null;
    }
    $this->closeConnection();
    return null;
  }

  public function updateKey(string $voter_id, string $voter_key)
  {
    try {
      $con = $this->getConnection();
      $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $sql = "UPDATE Voter SET voter_key = '$voter_key' where voter_id = '$voter_id'  ";

      // Prepare statement
      $stmt = $con->prepare($sql);

      // execute the query
      return  $stmt->execute();

    } catch (\PDOException $e) {
     // echo "Connection failed: " . $e->getMessage();
     return false;
    }
    $this->closeConnection();
    return false;
  }

  public function create_user(string $password, string $voter_id, string $username, int $voted, string $cni, string $contact_no, string $voter_key)
  {
    try {
      $con = $this->getConnection();
      $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $stmt = $con->prepare(
        "INSERT INTO Voter (voter_id, username, cni, voted, contact_no, password, voter_key)
                     VALUES (:voter_id, :username, :cni, :voted, :contact_no, :password, :voter_key)"
      );

      $stmt->bindParam(':voter_id', $voter_id);
      $stmt->bindParam(':username', $username);
      $stmt->bindParam(':cni', $cni);
      $stmt->bindParam(':voted', $voted);
      $stmt->bindParam(':contact_no', $contact_no);
      $password = hash("sha256", $password);
      $stmt->bindParam(':password', $password);
      $stmt->bindParam(':voter_key', $voter_key);

      $stmt->execute();

      return true;
    } catch (\PDOException $e) {
     // echo "Connection failed: " . $e->getMessage();
     return false;
    }
    $this->closeConnection();
    return false;
  }

  public function listVoter():?array
  {
    try {
      $con = $this->getConnection();
      $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $stmt = $con->prepare("SELECT voter_id, username, voted FROM Voter ");
      $stmt->execute();
      $stmt->setFetchMode(PDO::FETCH_ASSOC);
      return ($stmt->fetchAll());
    } catch (\PDOException $e) {
      //echo "Connection failed: " . $e->getMessage();
      return null;
    }
    $this->closeConnection();
    return null;
  }


  public function loginVote():?array
  {
    try {
      $con = $this->getConnection();
      $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $stmt = $con->prepare("SELECT * FROM Voter ");
      $stmt->execute();
      $stmt->setFetchMode(PDO::FETCH_ASSOC);
      return ($stmt->fetchAll());
    } catch (\PDOException $e) {
     // echo "Connection failed: " . $e->getMessage();
     return null;
    }
    $this->closeConnection();
    return null;
  }

  public function castVote(string $voter_id, string $voter_key, int $v)
  {
    try {
      $con = $this->getConnection();
      $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $sql = "UPDATE Voter SET voted = '$v' where voter_id = '$voter_id' and voter_key = '$voter_key' ";

      // Prepare statement
      $stmt = $con->prepare($sql);

      // execute the query
      $stmt->execute();

      return true;
    } catch (\PDOException $e) {
     // echo "Connection failed: " . $e->getMessage();
     return false;
    }
    $this->closeConnection();
    return false;
  }

  public function checkCast(string $voter_id)
  {
    try {
      $con = $this->getConnection();
      $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $stmt = $con->prepare("SELECT * FROM Voter where voted = '1' and voter_id = '$voter_id' ");
      $stmt->execute();
      $stmt->setFetchMode(PDO::FETCH_ASSOC);
      $result = $stmt->fetchAll();

      if (count($result) === 1) {
        return true;
      } else {
        return false;
      }
    } catch (\PDOException $e) {
      //echo "Connection failed: " . $e->getMessage();
      return false;
    }
    $this->closeConnection();
    return false;
  }

  public function addBlock(int $index = null, string $hash = null, string $previousHash = null, string $data, string $timestamp = null)
  {
    try {
      $con = $this->getConnection();
      $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $stmt = $con->prepare(
        "INSERT INTO Blockchain (`index`, `hash`, `previousHash`, `data`, `timestamp`)
                     VALUES (:index, :hash, :previousHash, :data, :timestamp)"
      );

      $stmt->bindParam(':index', $index);
      $stmt->bindParam(':hash', $hash);
      $stmt->bindParam(':previousHash', $previousHash);
      $stmt->bindParam(':data', $data);
      $stmt->bindParam(':timestamp', $timestamp);
      $stmt->execute();

      return true;
    } catch (\PDOException $e) {
      //echo "Connection failed: " . $e->getMessage();
      return false;
    }
    $this->closeConnection();
    return false;
  }

  public function getBlockchain():?array
  {
    try {
      $con = $this->getConnection();
      $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $stmt = $con->prepare("SELECT * FROM `Blockchain` ");
      $stmt->execute();
      $stmt->setFetchMode(PDO::FETCH_ASSOC);
      return ($stmt->fetchAll());
    } catch (\PDOException $e) {
      //echo "Connection failed: " . $e->getMessage();
      return null;
    }
    $this->closeConnection();
    return null;
  }
}
