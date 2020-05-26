<?php

namespace App\Navcoin\Block\Api;

use App\Exception\BlockNotFoundException;
use App\Navcoin\Block\Entity\Block;
use App\Navcoin\Block\Entity\BlockCycle;
use App\Navcoin\Block\Entity\Blocks;
use App\Navcoin\Common\Entity\IteratorEntityInterface;
use App\Navcoin\Common\NavcoinApi;
use GuzzleHttp\Exception\ClientException;
use Symfony\Component\HttpFoundation\Response;

class BlockApi extends NavcoinApi
{
    public function getBlock(String $height): Block
    {
        try {
            $response = $this->getClient()->get('/block/'.$height);
            $data = $this->getClient()->getJsonBody($response);
        } catch (ClientException $e) {
            switch ($e->getResponse()->getStatusCode()) {
                case Response::HTTP_NOT_FOUND:
                    throw new BlockNotFoundException(sprintf("The `%s` block does not exist.", $height), 0, $e);
                default:
                    throw $e;
            }
        }

        return $this->getMapper()->mapEntity($data);
    }

    public function getRawBlock(String $hash): String
    {
        try {
            $response = $this->getClient()->get('/block/'.$hash.'/raw');
            $data = $this->getClient()->getBody($response);
        } catch (ClientException $e) {
            switch ($e->getResponse()->getStatusCode()) {
                case Response::HTTP_NOT_FOUND:
                    throw new BlockNotFoundException(sprintf("The `%s` block does not exist.", $hash), 0, $e);
                default:
                    throw $e;
            }
        }

        return $data;
    }

    public function getBestBlock(): Block
    {
        $blocks = $this->getBlocks(1);

        return $blocks->getElement(0);
    }

    public function getBlocks(int $size = 50, int $page = 1, $paginate = true): IteratorEntityInterface
    {
        try {
            $response = $this->getClient()->get(sprintf('/block?size=%d&page=%d', $size, $page));
            $data = $this->getClient()->getJsonBody($response);
        } catch (ClientException $e) {
            return new Blocks();
        }

        $paginator = $paginate ? $this->getClient()->getPaginator($response) : null;
        return $this->getMapper()->mapIterator(Blocks::class, $data, $paginator);
    }

    public function getBlockCycle(): BlockCycle
    {
        $response = $this->getClient()->get('/blockcycle');
        $data = $this->getClient()->getJsonBody($response);

        return new BlockCycle(
            $data['size'],
            $data['cycle'],
            $data['index']
        );
    }
}
