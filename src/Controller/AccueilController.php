<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{

    private function callAPI($options){
        extract($options);

        $ch = curl_init();

        $header = array(
            "Content-Type: application/json"
        );

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);

        if($method)
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        $response = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        return array('response' => $response, 'info' => $info);
    }


    #[Route('/', name: 'app_accueil')]
    public function index(): Response
    {
        $options = [
            'url' => "https://data.grandlyon.com/fr/datapusher/ws/grandlyon/lyon.toilettepublique_latest/all.json?maxfeatures=-1&start=1",
            'method' => "GET"
        ];
        $result = $this->callAPI($options);

        $json = json_decode($result["response"]);
        dd($json);
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }
}
