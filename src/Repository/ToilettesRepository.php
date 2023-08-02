<?php

namespace App\Repository;


class ToilettesRepository {

    public $toilettes;

    // Constructor
    public function __construct()
    {
        $response = file_get_contents('https://data.grandlyon.com/fr/datapusher/ws/grandlyon/lyon.toilettepublique_latest/all.json?maxfeatures=-1&start=1');

        // Initialize properties with constructor parameters
        $this->toilettes = json_decode($response, true)["values"];
    }

    public function search($searchValue) {
        if (!isset($searchValue) || $searchValue === '') {
            $searchResult = $this->toilettes;
        } else {
            $searchResult = array_filter($this->toilettes, function ($item) use ($searchValue) {
                $isCodePostal = isset($item['codepost']) && $item['codepost'] == $searchValue;
                $isNom = isset($item['nom']) && strpos(strtolower($item['nom']),strtolower($searchValue)) !== false;
                return $isCodePostal || $isNom;
            });
        }
        return $searchResult;

    }

}