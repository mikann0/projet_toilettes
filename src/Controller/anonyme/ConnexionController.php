<?php

namespace App\Controller\anonyme;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConnexionController extends AbstractController
{
    #[Route('/connexion', name: 'app_connexion')]
    public function index(): Response
    {
        return $this->render('anonyme/connexion/index.html.twig', [
            'controller_name' => 'ConnexionController',
        ]);
    }
}
