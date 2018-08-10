<?php

namespace App\Controller;

use App\Exception\AddressInvalidException;
use App\Navcoin\Address\Api\AddressApi;
use App\Navcoin\Address\Api\TransactionApi;
use App\Navcoin\Address\Type\Filter\AddressTransactionTypeFilter;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AddressController
 *
 * @package App\Controller
 */
class AddressController extends Controller
{
    /**
     * @var AddressApi
     */
    private $addressApi;

    /**
     * @var TransactionApi
     */
    private $transactionApi;

    /**
     * @var int
     */
    private $pageSize = 50;

    /**
     * Constructor
     *
     * @param AddressApi     $addressApi
     * @param TransactionApi $transactionApi
     */
    public function __construct(AddressApi $addressApi, TransactionApi $transactionApi)
    {
        $this->addressApi = $addressApi;
        $this->transactionApi = $transactionApi;
    }

    /**
     * @Route("/address/{hash}")
     *
     * @param Request                      $request
     * @param string                       $hash
     * @param AddressTransactionTypeFilter $filter
     *
     * @return Response
     */
    public function index(Request $request, String $hash, AddressTransactionTypeFilter $filter): Response
    {
        try {
            $address = $this->addressApi->getAddress($hash);
        } catch (AddressInvalidException $e) {
            return $this->render('address/not_found.html.twig', [
                'hash' => $hash,
            ]);
        }

        return $this->render('address/index.html.twig', [
            'address' => $address,
            'hash' => $hash,
            'filter' => $filter,
            'filters' => $request->get('filters') ? explode(',', $request->get('filters')) : [],
        ]);
    }

    /**
     * @Route("/address/{hash}/tx.json")
     *
     * @param Request             $request
     * @param string              $hash
     * @param SerializerInterface $serializer
     *
     * @return Response
     */
    public function transactions(Request $request, String $hash, SerializerInterface $serializer): Response
    {
        $addressTransactions = $this->transactionApi->getTransactionsForAddress(
            $hash,
            $request->get('size', $this->pageSize),
            $request->get('filters', []),
            $request->get('from', null),
            $request->get('to', null)
        );

        return new Response($serializer->serialize($addressTransactions, 'json'));
    }
}
