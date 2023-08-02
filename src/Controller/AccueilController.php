<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{

    public $toilettes;

    // Constructor
    public function __construct()
    {
        $response = file_get_contents('https://data.grandlyon.com/fr/datapusher/ws/grandlyon/lyon.toilettepublique_latest/all.json?maxfeatures=-1&start=1');

        // Initialize properties with constructor parameters
        $this->toilettes = json_decode($response, true)["values"];
    }

    #[Route('/', name: 'app_accueil')]
    public function index(Request $request): Response
    {
        $searchValue = $request->query->get('searchValue');
        if (!isset($searchValue) || $searchValue === '') {
            $searchResult = $this->toilettes;
        } else {
            $searchResult = array_filter($this->toilettes, function ($item) use ($searchValue) {
                return isset($item['codepost']) && $item['codepost'] == $searchValue;
            });
        }
        return $this->render('accueil/index.html.twig', [
            'searchValue' => $searchValue,
            'toilettes' => $searchResult,
        ]);
    }
}
