<?php

namespace App\Controller\Api;

use App\Navcoin\Address\Api\StakingApi;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class StakeReportController
 *
 * @package App\Controller\Api
 */
class StakeReportController
{
    /**
     * @var StakingApi
     */
    private $stakingApi;

    /**
     * Constructor
     *
     * @param StakingApi $stakingApi
     */
    public function __construct(StakingApi $stakingApi)
    {
        $this->stakingApi = $stakingApi;
    }

    /**
     * @Route("/api/staking/report")
     * @Template()
     *
     * @param Request $request
     *
     * @return Response
     */
    public function getStakingReportAction(Request $request)
    {
        $dateFormat = 'Y-m-d H:i:s';
        if ($request->get('navaddress') == "") {
            return new JsonResponse(['error' => 'navaddress request parameter must be provided required'], 400);
        }

        if ($request->get('startdate') == "") {
            return new JsonResponse(['error' => 'startdate request parameter must be provided required'], 400);
        }

        if ($request->get('enddate') == "") {
            return new JsonResponse(['error' => 'enddate request parameter must be provided required'], 400);
        }

        $startDate = \DateTime::createFromFormat('Y-m-d H:i:s', $request->get('startdate'));
        if ($startDate === false) {
            return new JsonResponse(['error' => 'startdate is invalid. Accepted format is '.$dateFormat], 400);
        }
        $endDate = \DateTime::createFromFormat($dateFormat, $request->get('enddate'));
        if ($endDate === false) {
            return new JsonResponse(['error' => 'enddate is invalid. Accepted format is '.$dateFormat], 400);
        }

        $stakeReport = $this->stakingApi->getStakingReport(
            $request->get('navaddress'),
            \DateTime::createFromFormat('Y-m-d H:i:s', $request->get('startdate')),
            \DateTime::createFromFormat('Y-m-d H:i:s', $request->get('enddate'))
        );

        return new JsonResponse(['stake' => $stakeReport['stake']  / 100000000]);
    }
}
