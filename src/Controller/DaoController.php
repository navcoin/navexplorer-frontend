<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DaoController extends AbstractController
{
    /**
     * @Route("/dao")
     */
    public function indexAction() {
        return $this->render('dao/index.html.twig');
    }
}