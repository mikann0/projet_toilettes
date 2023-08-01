<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{

    #[Route('/', name: 'app_accueil')]
    public function index(): Response
    {
        $response = file_get_contents('https://data.grandlyon.com/fr/datapusher/ws/grandlyon/lyon.toilettepublique_latest/all.json?maxfeatures=-1&start=1');

        $response = json_decode($response);
        // dd($response);

        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }
}
