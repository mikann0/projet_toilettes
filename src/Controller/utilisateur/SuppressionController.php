<?php

namespace App\Controller\utilisateur;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Psr\Log\LogLevel;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Log\Logger;
use Symfony\Bundle\SecurityBundle\Security;


#[Route('/utilisateur')]
class SuppressionController extends AbstractController
{
    public $logger;
    // Constructor
    public function __construct()
    {
        // Initialize properties with constructor parameters
        $this->logger = new Logger();
    }
   
    #[Route('/suppression', name: 'app_suppression')]
    public function index(Security $security): Response
    {
        $token = $security->getToken();
        if ($token !== null) {
            $utilisateur = $token->getUser();
            return $this->render('utilisateur/suppression/index.html.twig', [
                'utilisateur' => $utilisateur,
            ]);
        }
    }
}
