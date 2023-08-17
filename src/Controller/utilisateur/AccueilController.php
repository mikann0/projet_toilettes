<?php

namespace App\Controller\utilisateur;

use App\Repository\ToilettesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/utilisateur')]
class AccueilController extends AbstractController
{
    public $toilettesRepository;
 // Constructor
 public function __construct(ToilettesRepository $repository)
 {
     // Initialize properties with constructor parameters
     $this->toilettesRepository = $repository;
 }

    #[Route('', name: 'app_utilisateur_accueil')]
    public function index(Request $request): Response
    {
        $searchValue = $request->query->get('searchValue');

        return $this->render('utilisateur/accueil/index.html.twig', [
            'searchValue' => $searchValue,
            'toilettes' => $this->toilettesRepository->search($searchValue),
        ]);
    }
}
