<?php

namespace App\Controller\moderation;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModerationController extends AbstractController
{
    #[Route('/moderation/controller', name: 'app_moderation_controller')]
    public function index(): Response
    {
        return $this->render('moderation/index.html.twig', [
            'controller_name' => 'ModerationControllrController',
        ]);
    }
}
