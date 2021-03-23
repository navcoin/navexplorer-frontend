<?php

namespace App\Controller;

use App\Exception\TransactionNotFoundException;
use App\Navcoin\Block\Api\BlockApi;
use App\Navcoin\Block\Api\TransactionApi;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class TransactionController extends AbstractController
{
    /** @var int */
    private $pageSize = 10;

    /** @var BlockApi */
    private $blockApi;

    /** @var TransactionApi */
    private $transactionApi;

    public function __construct(BlockApi $blockApi, TransactionApi $transactionApi)
    {
        $this->blockApi = $blockApi;
        $this->transactionApi = $transactionApi;
    }

    /**
     * @Route("/tx")
     * @Template()
     */
    public function index(): array
    {
        return [];
    }

    /**
     * @Route("/tx.json")
     */
    public function transactions(Request $request, SerializerInterface $serializer): Response
    {
        $transactions = $this->transactionApi->getTransactions(
            $request->get('filters', []),
            $request->get('size', $this->pageSize),
            $request->get('page', 1)
        );

        return new Response($serializer->serialize($transactions, 'json'), 200, [
            'paginator' => $serializer->serialize($transactions->getPaginator(), 'json')
        ]);
    }

    /**
     * @Route("/tx/latest.json")
     */
    public function latest(Request $request, SerializerInterface $serializer): Response
    {
        try {
            $latestTxs = $this->transactionApi->getLatestTransactions($request->get('count'));
        } catch (Exception $e) {
            return new Response("Unable to load latest transactions", $e->getCode());
        }

        return new Response($serializer->serialize($latestTxs->getElements(), 'json'));
    }

    /**
     * @Route("/tx/{hash}")
     * @Template()
     */
    public function view(Request $request)
    {
        try {
            $transaction = $this->transactionApi->getTransaction($request->get('hash'));
            $block = $this->blockApi->getBlock($transaction->getHeight());
            $rawData = $this->transactionApi->getRawTransaction($transaction->getHash());
        } catch(TransactionNotFoundException $e) {
            return $this->render(
                'transaction/not_found.html.twig',
                ['hash' => $request->get('hash')],
                new Response(null, 404)
            );
        }

        return [
            'transaction' => $transaction,
            'block' => $block,
            'raw' => $rawData,
        ];
    }
}
