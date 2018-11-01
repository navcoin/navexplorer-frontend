<?php

namespace App\Navcoin\Block\Api;

use App\Exception\BlockNotFoundException;
use App\Exception\ServerRequestException;
use App\Navcoin\Block\Entity\Block;
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
            $data = $this->getClient()->get('/api/block/'.$height);
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

    public function getBestBlock(): Block
    {
        try {
            $data = $this->getClient()->get('/api/block/best');
        } catch (ServerRequestException $e) {
            throw new BlockNotFoundException("Could not find the best block");
        }

        return $this->getMapper()->mapEntity($data);
    }

    public function getBlocks(int $size = 50, String $from = null, String $to = null): IteratorEntityInterface
    {
        $url = sprintf('/api/block/?page=%d&size=%d',0, $size);
        $url .= ($from !== null) ? sprintf('&from=%s', $from) : '';
        $url .= ($to !== null) ? sprintf('&to=%s', $to) : '';

        try {
            $data = $this->getClient()->get($url);
        } catch (ServerRequestException $e) {
            return new Blocks();
        }

        return $this->getMapper()->mapIterator($data, Blocks::class);
    }
}
