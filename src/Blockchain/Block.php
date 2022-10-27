<?php
// respect strict des types déclarés des paramètres de foctions
declare(strict_types=1);

namespace App\Blockchain;

use DateTimeImmutable;
use App\Utils\Utils;

class Block
{
    
    /**
     * @var int Représente l'index du block
     */
    private $index;

    /**
     * @var string Hash du block courant
     */
    private $hash;

    /**
     * @var string Hash du block précdédant
     */
    private $previousHash;

    /**
     * @var string Valeur stockée dans le bloc
     */
    private $data;

    /**
     * @var \DateTimeImmutable temps auquel a été créer le block
     */
    private $timestamp;

    /**
     * @var int
     */
    private $nonce;

    /**
     * Retourne l'index du block
     * @return int
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * Retourne le hash du block
     * @return string
     */
    public function getHash(): string
    {
        return (string) $this->hash;
    }

    /**
     * Retourne le hash du block précédent associé au block en cours 
     * @return string
     */
    public function getPreviousHash()
    {
        return (string)$this->previousHash;
    }

    /**
     * Retourne la donnée stockée dans le block
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Renvoi en milliseconde le temps auque le block a été crée
     * @return int
     */
    public function getTime(): int
    {
        return (int)$this->timestamp;
    }

    /**
     * Renvoi l'attribut nonce
     * @return int
     */
    public function getNonce(): int
    {
        return $this->nonce;
    }
    
      /**
     * Creation d'un block
     *
     * @param int $index
     * @param string $hash
     * @param string $previousHash
     * @param string $data
     * @param string $timestamp
     */
    public function __construct(int $index = null, string $hash = null, string $previousHash = null, string $data = "", string $timestamp = null)
    {
        $this->index = $index;
        $this->previousHash = $previousHash;
        $this->data = $data;
        $this->timestamp = (is_null($timestamp) ? (new DateTimeImmutable())->getTimestamp() : $timestamp);
        $this->nonce = 0;
        $this->hash = (is_null($hash) ? self::calculateHash($this) : $hash);
    }

    /**
     * Génère un hash pour le block courant
     * @return string
     */
    public static function calculateHash(Block $block): string
    {
        if ($block != null) {
            $hash = $block->index . $block->data . $block->nonce . $block->previousHash .
                $block->timestamp;
            return (string) hash("sha256", $hash);
        }

        return null;
    }

    /**
     * Cette function permet de miner un Block
     * @param int $difficulty
     */
    public function  mineBlock(int $difficulty): void
    {
        $this->nonce = 0;

        while (!(substr($this->getHash(), 0, $difficulty) === Utils::zeros($difficulty))) {
            $this->nonce++;
            $this->hash = self::calculateHash($this);
        }
    }

    public function getBlock(): array
    {
        $result = array(
            "index"        => $this->getIndex(),
            "hash"         => $this->getHash(),
            "previousHash" => $this->getPreviousHash(),
            "data"         => $this->getData(),
            "timestamp"    => $this->getTime()     //date("D, d M Y H:i:s \G\M\T", $this->getTime())
        );

        return $result;
    }
}
