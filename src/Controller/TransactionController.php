<?php

namespace App\Controller;

use App\Exception\TransactionNotFoundException;
use App\Navcoin\Block\Api\BlockApi;
use App\Navcoin\Block\Api\TransactionApi;
use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TransactionController extends Controller
{
    /**
     * @var int
     */
    private $pageSize = 10;

    /**
     * @var BlockApi
     */
    private $blockApi;

    /**
     * @var TransactionApi
     */
    private $transactionApi;

    public function __construct(BlockApi $blockApi, TransactionApi $transactionApi)
    {
        $this->blockApi = $blockApi;
        $this->transactionApi = $transactionApi;
    }

    /**
     * @Route("/tx")
     * @Template()
     *
     * @return array
     */
    public function index(): array
    {
        return [];
    }


    /**
     * @Route("/tx.json")
     *
     * @param Request             $request
     * @param SerializerInterface $serializer
     *
     * @return Response
     */
    public function transactions(Request $request, SerializerInterface $serializer): Response
    {
        $transactions = $this->transactionApi->getTransactions(
            $request->get('size', $this->pageSize),
            $request->get('from', null),
            $request->get('to', null)
        );

        return new Response($serializer->serialize($transactions, 'json'));
    }

    /**
     * @Route("/tx/{hash}")
     * @Template()
     *
     * @param Request $request
     *
     * @return array|Response
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
