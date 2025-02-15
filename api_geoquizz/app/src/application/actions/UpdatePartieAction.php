<?php

namespace api_geoquizz\application\actions;

use api_geoquizz\application\providers\JWTManager;
use api_geoquizz\application\renderer\JsonRenderer;
use api_geoquizz\core\domain\entities\partie\Partie;
use api_geoquizz\core\dto\DTOPartie;
use api_geoquizz\core\services\partie\ServicePartie;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UpdatePartieAction extends AbstractAction
{
    private ServicePartie $servicePartie;
    private JWTManager $jwtManager;

    public function __construct(ServicePartie $servicePartie, JWTManager $jwtManager)
    {
        $this->servicePartie = $servicePartie;
        $this->jwtManager = $jwtManager;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $body = $rq->getBody()->getContents();
        $data = json_decode($body, true);

        $token = $rq->getHeader('Authorization')[0];
        $token = str_replace('Bearer ', '', $token);
        $data2 = $this->jwtManager->decodeToken($token);

        if (empty($data)) {
            throw new \Exception('Aucun body fourni');
        }

        $partie = new Partie($data['sequence'], $data['score']);
        $dtoPartie = new DTOPartie($partie);

        $this->servicePartie->updatePartie($dtoPartie);

        return JSONRenderer::render($rs, 200, ['Update' => 'OK']);
    }
}