<?php
// respect strict des types déclarés des paramètres de foctions
declare(strict_types=1);

namespace App\Blockchain;
use \App\Blockchain\Block;

class Blockchain
{

    /**
     * @var int  Difficulté de minage
     */
    public $difficulty;

    /**
     * @var Array tableau contenant la liste des blocks
     */
    private $blocks;

    /**
     * Retourn l'ensemble de block
     * @return array
     */
    public function getBlocks():array
    {
        return (array) $this->blocks;
    }

    /**
     * Recupère les blocks du tableau $b
     * @param array $b tableau contenant les blocks
     * @return array
     */
    public function loadBlocks(array $b):array{
       for ($i=0; $i < count($b); $i++) { 
        $this->addBlock($b[$i]);
       }
        return $this->blocks;
    }

    public function __construct(int $difficulty = null)
    {
        $this->blocks = [];
        if(!is_null($difficulty)){
            $this->difficulty = $difficulty;
            // Création du premier block
            $block = new Block(0,"","");
            $block->mineBlock($this->difficulty);
            array_push($this->blocks, $block);
        }
    }

    public function getDifficulty(): int
    {
        return $this->difficulty;
    }

    public function latestBlock(): Block
    {
        return $this->blocks[sizeof($this->blocks) - 1];
    }

    public function newBlock(string $data): Block
    {
        $latestBlock = $this->latestBlock();
        return new Block($latestBlock->getIndex() + 1, null, $latestBlock->getHash(), $data);
    }

    public function addBlock(Block $b): void
    {
        if ($b != null) {
            if(!is_null($this->difficulty))
              $b->mineBlock($this->difficulty);
            array_push($this->blocks, $b);
        }
    }

    public function isFirstBlock(): bool
    {
        $firstBlock = $this->blocks[0];

        if ($firstBlock->getIndex() != 0) {
            return false;
        }

        if ($firstBlock->getPreviousHash() != null) {
            return false;
        }

        if ( 
            ($firstBlock->getHash() === null) ||
            ( Block::calculateHash($firstBlock) === $firstBlock->getHash())
        ) {
            return false;
        }

        return true;
    }

    public function isValidNewBlock(Block $newBlock, Block $previousBlock):bool
    {
        if( !is_null($newBlock) && !is_null($previousBlock))
        {
            if($previousBlock->getIndex() + 1 != $newBlock->getIndex())
            {
              return false;
            }

            if($newBlock->getPreviousHash() === null ||
              !($newBlock->getPreviousHash() === $previousBlock->getHash()) )
              {
               return false;
              }

              if($newBlock->getHash() === null || 
              ( Block::calculateHash($newBlock) === $newBlock->getHash()) )
              {
               return false;
              }

              return true;

        }
 
        return false;
    }

    public function isBlockChainValid():bool
    {
        if($this->isFirstBlock())
        {
            return false;
        }

        for ($i=1; $i < sizeof($this->blocks); $i++) { 
            # code...
            $currentBlock = $this->blocks[$i];
            $previousBlock = $this->blocks[$i-1];

            if(!$this->isValidNewBlock($currentBlock, $previousBlock))
            {
               return false;
            }
        }
        return true;
    }

    public function toJson()
    {
        $result = [];
        foreach ($this->blocks as $key => $value) {
            array_push($result, $value->getBlock());
        }
        return json_encode($result);
    }
}
