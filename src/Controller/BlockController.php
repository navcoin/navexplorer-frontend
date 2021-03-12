<?php

namespace App\Controller;

use App\Exception\BlockNotFoundException;
use App\Navcoin\Block\Api\BlockApi;
use App\Navcoin\Block\Api\TransactionApi;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class BlockController extends AbstractController
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
     * @Route("/blocks")
     * @Template()
     */
    public function index(): array
    {
        return [];
    }

    /**
     * @Route("/blocks.json")
     */
    public function blocks(Request $request, SerializerInterface $serializer): Response
    {
        $blocks = $this->blockApi->getBlocks(
            $request->get('size', $this->pageSize),
            $request->get('page', 1)
        );

        return new Response($serializer->serialize($blocks, 'json'), 200, [
            'paginator' => $serializer->serialize($blocks->getPaginator(), 'json'),
        ]);
    }

    /**
     * @Route("/block/{height}")
     */
    public function view(Request $request)
    {
        try {
            $block = $this->blockApi->getBlock($request->get('height'));
            $rawData = $this->blockApi->getRawBlock($block->getHash());
        } catch (BlockNotFoundException $e) {
            return $this->render(
                'block/not_found.html.twig',
                ['height' => $request->get('height')],
                new Response(null, 404)
            );
        }

        return $this->render('block/view.html.twig', [
            'block' => $block,
            'raw' => $rawData,
        ]);
    }

    /**
     * @Route("/block/{height}/tx.json")
     */
    public function transactions(Request $request, SerializerInterface $serializer): Response
    {
        $transactions = $this->transactionApi->getTransactionsForBlock($request->get('height'));

        return new Response($serializer->serialize($transactions, 'json'), 200, [
            'paginator' => $serializer->serialize($transactions->getPaginator(), 'json'),
        ]);
    }
}
