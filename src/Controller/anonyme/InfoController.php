<?php

namespace App\Controller\anonyme;

use App\Repository\ToilettesRepository;
use Psr\Log\LogLevel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Log\Logger;
use Symfony\Component\Routing\Annotation\Route;

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

    #[Route('/toilette/{tid}', name: 'app_info')]
    public function index($tid): Response
    {
        $this->logger->log(LogLevel::WARNING, "Request toilette with id=".$tid);
        $uneToilette = $this->toilettesRepository->uneToilette($tid);
        return $this->render('anonyme/info/index.html.twig', [
            'toilette' => $uneToilette,
        ]);
    }
}
