<?php

namespace App\Controller\anonyme;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NouveauMdpController extends AbstractController
{
    #[Route('/nouveau/mdp', name: 'app_nouveau_mdp')]
    public function index(): Response
    {
        return $this->render('anonyme/nouveau_mdp/index.html.twig', [
            'controller_name' => 'NouveauMdpController',
        ]);
    }
}
