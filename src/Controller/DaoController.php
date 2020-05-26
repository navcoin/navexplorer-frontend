<?php

namespace App\Controller;

use App\Navcoin\Block\Api\BlockApi;
use App\Navcoin\CommunityFund\Constants\PaymentRequestState;
use App\Navcoin\CommunityFund\Constants\PaymentRequestStatus;
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
     * @Route("/dao/consensus")
     * @Template()
     */
    public function consensusAction() {
        return [
            'parameters' => $this->consensusApi->getConsensusParameters(),
        ];
    }

    /**
     * @Route("/dao/consensus/{id}/consultations")
     * @Template()
     */
    public function consensusConsultationsAction(Request $request)
    {
        $parameter = $this->consensusApi->getConsensusParameter($request->get('id'));

        $consultations = $this->consultationApi->getConsultations(['consensus' => true, 'min' => $parameter->getId()],
            9, $request->get('page', 1), true);

        return [
            'parameter' => $parameter,
            'consultations' => $consultations->getElements(),
            'paginator' => $consultations->getPaginator(),
            'active' => null,
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
            case ConsultationStatus::VOTING_STARTED:
                $state = ConsultationState::VOTING_STARTED;
                break;
            case ConsultationStatus::EXPIRED:
                $state = ConsultationState::EXPIRED;
                break;
            case ConsultationStatus::REFLECTION:
                $state = ConsultationState::REFLECTION;
                break;
            case ConsultationStatus::PASSED:
                $state = ConsultationState::PASSED;
                break;
            case ConsultationStatus::FOUND_SUPPORT:
                $state = ConsultationState::FOUND_SUPPORT;
                break;
            default:
                return $this->redirectToRoute('app_dao_consensusconsultations', ['status' => ConsultationStatus::WAITING_FOR_SUPPORT]);
        }


        $consultations = $this->consultationApi->getConsultations(['state' => $state], 9, $request->get('page', 1), true);

        return [
            'blockCycle' => $this->blockApi->getBlockCycle(),
            'consultations' => $consultations->getElements(),
            'paginator' => $consultations->getPaginator(),
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
            'blockCycle' => $this->blockApi->getBlockCycle(),
            'consultation' => $this->consultationApi->getByHash($request->get('hash')),
            'consensus' => $consensusParameter,
        ];
    }
}