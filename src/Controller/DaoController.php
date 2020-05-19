<?php

namespace App\Controller;

use App\Navcoin\Block\Api\BlockApi;
use App\Navcoin\Dao\Api\ConsultationApi;
use App\Navcoin\Dao\Api\ConsensusApi;
use App\Navcoin\CommunityFund\Api\ProposalApi;
use App\Navcoin\Dao\Constants\ConsultationState;
use App\Navcoin\Dao\Constants\ConsultationStatus;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DaoController extends AbstractController
{
    /** @var ConsultationApi */
    private $consultationApi;

    /** @var ConsensusApi */
    private $consensusApi;

    /** @var ProposalApi */
    private $proposalApi;

    /** @var BlockApi */
    private $blockApi;

    /** @var int */
    private $pageSize = 4;

    public function __construct(ConsultationApi $consultationApi, ConsensusApi $consensusApi, ProposalApi $proposalApi, BlockApi $blockApi)
    {
        $this->consultationApi = $consultationApi;
        $this->consensusApi = $consensusApi;
        $this->proposalApi = $proposalApi;
        $this->blockApi = $blockApi;
    }

    /**
     * @Route("/dao")
     * @Template()
     */
    public function indexAction() {
        return [];
    }

    /**
     * @Route("/dao/consensus/parameters")
     * @Template()
     */
    public function consensusParametersAction() {
        return [
            'parameters' => $this->consensusApi->getConsensusParameters(),
        ];
    }

    /**
     * @Route("/dao/consensus/consultations")
     * @Template()
     */
    public function consensusConsultationsAction(Request $request) {
        $size = $request->get('size', 500);
        $page = $request->get('page', 1);

        return [
            'blockCycle' => $this->blockApi->getBlockCycle(),
            'consultations' => $this->consultationApi->getConsultations($size, $page, [
                'consensus' => true,
            ]),
        ];
    }

    /**
     * @Route("/dao/consultations/{status}")
     * @Template()
     */
    public function consultationsAction(Request $request) {
        switch($request->get('status')) {
            case ConsultationStatus::WAITING_FOR_SUPPORT:
                $state = ConsultationState::WAITING_FOR_SUPPORT;
                break;
            case ConsultationStatus::EXPIRED:
                $state = ConsultationState::EXPIRED;
                break;
            case ConsultationStatus::PASSED:
                $state = ConsultationState::PASSED;
                break;
            case ConsultationStatus::REFLECTION:
                $state = ConsultationState::REFLECTION;
                break;
            case ConsultationStatus::FOUND_SUPPORT:
                $state = ConsultationState::FOUND_SUPPORT;
                break;
            default:
                return $this->redirectToRoute('app_dao_consultations', ['status' => ConsultationStatus::WAITING_FOR_SUPPORT]);
        }
        $size = $request->get('size', $this->pageSize);
        $page = $request->get('page', 1);
        $parameters = [
          'state' => $state,
        ];

        return [
            'blockCycle' => $this->proposalApi->getBlockCycle(),
            'consultations' => $this->consultationApi->getConsultations($size, $page, $parameters),
            'active' => $request->get('status'),
        ];
    }

    /**
     * @Route("/dao/consultation/{hash}")
     * @Template()
     */
    public function consultationAction(Request $request) {
        $consultation = $this->consultationApi->getByHash($request->get('hash'));
        $consensusParameter = $consultation->isConsensusParameter() ? $this->consensusApi->getConsensusParameter($consultation->getMin()) : null;

        return [
            'blockCycle' => $this->proposalApi->getBlockCycle(),
            'consultation' => $this->consultationApi->getByHash($request->get('hash')),
            'consensus' => $consensusParameter,
        ];
    }
}