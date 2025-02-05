<?php

namespace api_geoquizz\application\actions;

use api_geoquizz\application\providers\JWTManager;
use api_geoquizz\application\renderer\JsonRenderer;
use api_geoquizz\core\dto\InputPartieDTO;
use api_geoquizz\core\services\partie\ServicePartieInterface;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Validator;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;

class CreatePartieAction extends AbstractAction
{
    private ServicePartieInterface $servicePartie;
    private ClientInterface $directus_client;
    private JWTManager $jwtManager;

    public function __construct(ServicePartieInterface $servicePartie, ClientInterface $directus_client, JWTManager $jwtManager)
    {
        $this->servicePartie = $servicePartie;
        $this->directus_client = $directus_client;
        $this->jwtManager = $jwtManager;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $sequence = "";
        $body = $rq->getParsedBody();
        $data = $body;
        $token = $rq->getHeader('Authorization')[0];
        $token = str_replace('Bearer ', '', $token);
        $data2 = $this->jwtManager->decodeToken($token);

        $validator = Validator::key('nom', Validator::stringType()->notEmpty())->validate($data);
        if ($validator !== true) {
            throw new HttpBadRequestException($rq, "Les données fournies ne sont pas valides.");
        }

        try {
            $params = [
                'query' => [
                    'fields' => 'id'
                ]
            ];
            $response = $this->directus_client->request('GET', '/items/Photo', $params);

            $array = json_decode($response->getBody(), true);
            $interVale = array_map(function ($item) {
                return $item['id'];
            }, $array['data']);

            if (count($interVale) >= 10) {
                shuffle($interVale);
                $random_keys = array_rand($interVale, 10);

                $random_values = "[";
                foreach ($random_keys as $key) {
                    $random_values = $random_values.''.$interVale[$key];
                    if ($key < 9) {
                        $random_values = $random_values.', ';
                    } else {
                        $random_values = $random_values.']';
                    }
                }

                $sequence = $random_values;
            } else {
                echo "Le tableau n'a pas suffisamment d'éléments.";
            }
        } catch (GuzzleException $e) {
            throw new \Exception($e->getMessage());
        }

        $name = $data['nom'];
        $idSequence= $this->servicePartie->createSequence($sequence, $name);

        $data['sequence_photo'] = $idSequence;
        $data['score'] = 0;

        $partieInputDto = new InputPartieDTO($data);

        $data['token'] = $this->jwtManager->createAcessToken($data2['data']->id);

        $this->servicePartie->createPartie($partieInputDto);

        return JSONRenderer::render($rs, 201, $data);

    }
}