<?php

namespace App\Controller\utilisateur;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/utilisateur')]
class SuppressionController extends AbstractController
{
    #[Route('/suppression', name: 'app_suppression')]
    public function index(): Response
    {
        return $this->render('utilisateur/suppression/index.html.twig', [
            'controller_name' => 'SuppressionController',
        ]);
    }
}
