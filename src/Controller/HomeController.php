<?php

namespace App\Controller;

use App\Navcoin\Block\Api\BlockApi;
use App\Navcoin\Block\Api\BlockGroupApi;
use App\Navcoin\Common\Network;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**  @var BlockGroupApi */
    private $blockGroupApi;

    /**  @var BlockApi */
    private $blockApi;

    public function __construct(BlockGroupApi $blockGroupApi, BlockApi $blockApi)
    {
        $this->blockGroupApi = $blockGroupApi;
        $this->blockApi = $blockApi;
    }

    /**
     * @Route("/")
     * @Template()
     */
    public function index(Request $request): array
    {
        return [
            'blocks' => $this->blockGroupApi->getGroupByCategory($request->get('period', 'hourly'), 5),
            'best' => $this->blockApi->getBestBlock(),
        ];
    }

    /**
     * @Route("/network/{network}")
     * @Template()
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
