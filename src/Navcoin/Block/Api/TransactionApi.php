<?php

namespace App\Navcoin\Block\Api;

use App\Navcoin\Block\Entity\Transaction;
use App\Navcoin\Block\Entity\Transactions;
use App\Exception\BlockNotFoundException;
use App\Exception\ServerRequestException;
use App\Exception\TransactionNotFoundException;
use App\Navcoin\Common\Entity\IteratorEntityInterface;
use App\Navcoin\Common\NavcoinApi;
use GuzzleHttp\Exception\ClientException;
use Symfony\Component\HttpFoundation\Response;

class TransactionApi extends NavcoinApi
{
    public function getTransaction(String $hash): Transaction
    {
        try {
            $data = $this->getClient()->get('/api/tx/'.$hash);
        } catch (ClientException $e) {
            switch ($e->getResponse()->getStatusCode()) {
                case Response::HTTP_NOT_FOUND:
                    throw new TransactionNotFoundException(sprintf("The transaction %s does not exist.", $hash), 0, $e);
                default:
                    throw $e;
            }

        }

        return $this->getMapper()->mapEntity($data);
    }

    public function getTransactions(int $size = 50, String $from = null, String $to = null): IteratorEntityInterface
    {
        $url = sprintf('/api/tx/?page=%d&size=%d',0, $size);
        $url .= ($from !== null) ? sprintf('&from=%s', $from) : '';
        $url .= ($to !== null) ? sprintf('&to=%s', $to) : '';

        try {
            $data = $this->getClient()->get($url);
        } catch (ServerRequestException $e) {
            return new Transactions();
        }

        return $this->getMapper()->mapIterator($data, Transactions::class);
    }

    public function getTransactionsForBlock(String $height): IteratorEntityInterface
    {
        try {
            $data = $this->getClient()->get('/api/block/'.$height.'/tx');
        } catch (ServerRequestException $e) {
            throw new BlockNotFoundException(sprintf("The block at height %s does not exist.", $height), 0, $e);
        }

        return $this->getMapper()->mapIterator($data, Transactions::class);
    }
}
