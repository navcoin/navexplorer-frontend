<?php

namespace App\Controller;

use App\Navcoin\Block\Api\BlockGroupApi;
use App\Navcoin\Common\Network;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends Controller
{
    /**
     * @var BlockGroupApi
     */
    private $blockGroupApi;

    public function __construct(BlockGroupApi $blockGroupApi)
    {
        $this->blockGroupApi = $blockGroupApi;
    }

    /**
     * @Route("/")
     * @Template()
     *
     * @param Request $request
     *
     * @return array
     */
    public function index(Request $request): array
    {
        return [
            'blocks' => $this->blockGroupApi->getGroupByCategory($request->get('period', 'hourly'), 10)
        ];
    }

    /**
     * @Route("/network/{network}")
     * @Template()
     *
     * @param Request $request
     * @param Session $session
     *
     * @return RedirectResponse
     */
    public function network(Request $request, Session $session): RedirectResponse
    {
        $network = $request->get('network');
        switch ($network) {
            case 'testnet':
                $network = Network::TEST_NET;
                break;
            default:
                $network = Network::MAIN_NET;
        }

        $session->set('network', $network);

        return $this->redirectToRoute('app_home_index');
    }
}
