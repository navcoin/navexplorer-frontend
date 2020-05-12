<?php

namespace App\Controller;

use App\Navcoin\Dao\Api\ConsultationApi;
use App\Navcoin\Dao\Api\ConsensusApi;
use App\Navcoin\CommunityFund\Api\ProposalApi;
use App\Navcoin\Dao\Constants\ConsultationState;
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

    public function __construct(ConsultationApi $consultationApi, ConsensusApi $consensusApi, ProposalApi $proposalApi)
    {
        $this->consultationApi = $consultationApi;
        $this->consensusApi = $consensusApi;
        $this->proposalApi = $proposalApi;
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
        return [
            'blockCycle' => $this->proposalApi->getBlockCycle(),
            'consultations' => $this->consultationApi->getAllConsensus(),
        ];
    }

    /**
     * @Route("/dao/consultations/{status}")
     * @Template()
     */
    public function consultationsAction(Request $request) {
        switch($request->get('status')) {
            case 'waiting-for-support':
                $consultations = $this->consultationApi->getByState(ConsultationState::WAITING_FOR_SUPPORT);
                break;
            case 'expired':
                $consultations = $this->consultationApi->getByState(ConsultationState::EXPIRED);
                break;
            case 'passed':
                $consultations = $this->consultationApi->getByState(ConsultationState::PASSED);
                break;
            case 'reflection':
                $consultations = $this->consultationApi->getByState(ConsultationState::REFLECTION);
                break;
            case 'found-support':
                $consultations = $this->consultationApi->getByState(ConsultationState::FOUND_SUPPORT);
                break;
            default:
                return $this->redirectToRoute('app_dao_consultations', ['status' => 'waiting-for-support']);
        }

        return [
            'blockCycle' => $this->proposalApi->getBlockCycle(),
            'consultations' => $consultations,
            'active' => $request->get('status'),
        ];
    }

    /**
     * @Route("/dao/consultation/{hash}")
     * @Template()
     */
    public function consultationAction(Request $request) {
        return [
            'consultation' => $this->consultationApi->getByHash($request->get('hash')),
        ];
    }
}