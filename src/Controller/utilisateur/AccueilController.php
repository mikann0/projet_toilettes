<?php

namespace App\Controller\utilisateur;

use App\Repository\ToilettesRepository;
use Psr\Log\LogLevel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Log\Logger;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/utilisateur')]
class AccueilController extends AbstractController
{
    public $toilettesRepository;
    public $logger;
 // Constructor
 public function __construct(ToilettesRepository $repository)
 {
     // Initialize properties with constructor parameters
     $this->toilettesRepository = $repository;
     $this->logger = new Logger();
 }

    #[Route('', name: 'app_utilisateur_accueil')]
    public function index(Request $request, Security $security): Response
    {        
        $token = $security->getToken();
        $searchValue = $request->query->get('searchValue');
        if ($token !== null) {
            $this->logger->log(LogLevel::WARNING, "token=" . $token);
            $utilisateur = $token->getUser();
            return $this->render('utilisateur/accueil/index.html.twig', [
                'searchValue' => $searchValue,
                'toilettes' => $this->toilettesRepository->search($searchValue),
                'utilisateur' => $utilisateur,
            ]);
        }

    }
}
