<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Psr\Log\LogLevel;
use Symfony\Component\HttpKernel\Log\Logger;

class ToilettesRepository
{

    private $toilettes;
    private $logger;

    // Constructor
    public function __construct()
    {
        // $response = file_get_contents('https://data.grandlyon.com/fr/datapusher/ws/grandlyon/lyon.toilettepublique_latest/all.json?maxfeatures=-1&start=1');

        $response = file_get_contents("build/files/all.json");

        $this->logger = new Logger();
        $this->logger->log(LogLevel::WARNING, "Create repository");

        // Initialize properties with constructor parameters
        $this->toilettes = json_decode($response, true)["values"];
    }

    public function search($searchValue)
    {
        $this->logger->log(LogLevel::INFO, "Searching value " . $searchValue);
        if (!isset($searchValue) || $searchValue === '') {
            $searchResult = $this->toilettes;
        } else {
            $searchResult = array_filter($this->toilettes, function ($item) use ($searchValue) {
                $isCodePostal = isset($item['codepost']) && $item['codepost'] == $searchValue;
                $isNom = isset($item['nom']) && str_contains(strtolower($item['nom']), strtolower($searchValue));
                $isAdresse = isset($item['adresse']) &&
                    str_contains(strtolower($item['adresse']), strtolower($searchValue));
                return $isCodePostal || $isNom || $isAdresse;
            });
        }
        return $searchResult;
    }

    public function uneToilette($id)
    {

        for ($i = 0; $i < count($this->toilettes); $i++) {
            $item = $this->toilettes[$i];
            if(isset($item['uid']) && $item['uid'] == $id) {
                return $item;
            }
        }
        return null;
    }


}