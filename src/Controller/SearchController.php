<?php

namespace App\Controller;

use App\Navcoin\Search\Api\SearchApi;
use App\Navcoin\Search\Exception\SearchResultMissException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SearchController
 *
 * @package App\Controller
 */
class SearchController extends Controller
{
    /**
     * @var SearchApi
     */
    private $searchApi;

    /**
     * Constructor
     *
     * @param SearchApi $searchApi
     */
    public function __construct(SearchApi $searchApi)
    {
        $this->searchApi = $searchApi;
    }

    /**
     * @Route("/search")
     * @Template()
     *
     * @return array
     */
    public function searchAction()
    {
        return [

        ];
    }

    /**
     * @Route("/search/results")
     * @Template()
     *
     * @param Request $request
     *
     * @return array|RedirectResponse
     */
    public function resultsAction(Request $request)
    {
        $hash = $request->get('hash', 'a');

        try {
            if ($hash !== '') {
                $result = $this->searchApi->search($request->get('hash', ''));
                switch ($result->getType()) {
                    case 'block':
                        return $this->redirectToRoute('app_block_view', ['height' => $result->getValue()]);
                    case 'transaction':
                        return $this->redirectToRoute('app_transaction_view', ['hash' => $result->getValue()]);
                    case 'address':
                        return $this->redirectToRoute('app_address_index', ['hash' => $result->getValue()]);
                }
            }
        } catch (SearchResultMissException $e) {
            //
        }

        return [
            'hash' => $hash,
        ];
    }
}
