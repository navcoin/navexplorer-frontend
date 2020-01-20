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
            $response = $this->getClient()->get('/tx/' . $hash);
            $data = $this->getClient()->getJsonBody($response);
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

    public function getRawTransaction(String $hash): String
    {
        try {
            $response = $this->getClient()->get('/tx/'.$hash.'/raw');
            $data = $this->getClient()->getBody($response);
        } catch (ClientException $e) {
            switch ($e->getResponse()->getStatusCode()) {
                case Response::HTTP_NOT_FOUND:
                    throw new BlockNotFoundException(sprintf("The `%s` transaction does not exist.", $hash), 0, $e);
                default:
                    throw $e;
            }
        }

        return $data;
    }

    public function getTransactions(int $size = 50, String $from = null, String $to = null): IteratorEntityInterface
    {
        $url = sprintf('/api/tx/?page=%d&size=%d',0, $size);
        $url .= ($from !== null) ? sprintf('&from=%s', $from) : '';
        $url .= ($to !== null) ? sprintf('&to=%s', $to) : '';

        try {
            $response = $this->getClient()->get($url);
            $data = $this->getClient()->getJsonBody($response);
        } catch (ClientException $e) {
            return new Transactions();
        }

        return $this->getMapper()->mapIterator(Transactions::class, $data);
    }

    public function getTransactionsForBlock(String $height): IteratorEntityInterface
    {
        try {
            $response = $this->getClient()->get('/block/'.$height.'/tx');
            $data = $this->getClient()->getJsonBody($response);
        } catch (ClientException $e) {
            throw new BlockNotFoundException(sprintf("The block at height %s does not exist.", $height), 0, $e);
        }

        return $this->getMapper()->mapIterator( Transactions::class, $data);
    }
}
