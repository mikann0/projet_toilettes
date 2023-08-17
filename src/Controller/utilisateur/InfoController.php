<?php

namespace App\Controller\utilisateur;

use App\Repository\ToilettesRepository;
use Psr\Log\LogLevel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Log\Logger;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/utilisateur')]
class InfoController extends AbstractController
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

    #[Route('/toilette/{id}', name: 'app_utilisateur_info')]
    public function index($id): Response
    {
        $this->logger->log(LogLevel::WARNING, "Request toilette with id=".$id);
        $uneToilette = $this->toilettesRepository->uneToilette($id);
        return $this->render('utilisateur/info/index.html.twig', [
            'toilette' => $uneToilette,
        ]);
    }
}
