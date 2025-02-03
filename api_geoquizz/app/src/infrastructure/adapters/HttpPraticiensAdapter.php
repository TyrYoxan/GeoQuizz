<?php
namespace api_geoquizz\infrastructure\adapters;


use \GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class HttpPraticiensAdapter implements ServicePraticiensAdapterInterface
{
    private Client $praticiens_client;

    public function __construct(Client $praticiens_client){
        $this->praticiens_client = $praticiens_client;
    }

    /**
     * @throws GuzzleException
     */
    public function getPraticienById(string $praticienId): PraticienDTO
    {
        $data = $this->praticiens_client->request('GET', '/praticiens/'.$praticienId);
        $data = json_decode($data->getBody()->getContents(), true);
        $praticienData = $data['praticien'];

        $praticien = new Praticien(
            $praticienData['nom'],
            $praticienData['prenom'],
            $praticienData['adresse'],
            $praticienData['tel'],
            $praticienData['specialite_label']
        );
        $praticien->setID($praticienData['ID']);
        return $praticien->toDTO();
    }
}
