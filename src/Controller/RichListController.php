<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RichListController extends AbstractController
{
    /**
     * @Route("/rich-list")
     */
    public function index(Request $request)
    {
        return $this->redirectToRoute(
            "app_address_addresses",
            ["status" => $request->get("status")],
            301
        );
    }
}
