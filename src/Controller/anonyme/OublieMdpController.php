<?php

namespace App\Controller\anonyme;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OublieMdpController extends AbstractController
{
    #[Route('/oublie/mdp', name: 'app_oublie_mdp')]
    public function index(): Response
    {
        return $this->render('anonyme/oublie_mdp/index.html.twig', [
            'controller_name' => 'OublieMdpController',
        ]);
    }
}
