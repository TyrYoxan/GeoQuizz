<?php

namespace api_geoquizz\application\actions;

use api_geoquizz\application\providers\JWTManager;
use api_geoquizz\application\renderer\JsonRenderer;
use api_geoquizz\core\services\partie\ServicePartieInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetProfilAction extends AbstractAction
{
    private JWTManager $jwtManager;
    private ServicePartieInterface $servicePartie;

    public function __construct(JWTManager $jwtManager, ServicePartieInterface $servicePartie)
    {
            $this->jwtManager = $jwtManager;
            $this->servicePartie = $servicePartie;
    }
    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $token = $rq->getHeader('Authorization')[0];
        $token = str_replace('Bearer ', '', $token);
        $data = $this->jwtManager->decodeToken($token);

        if (empty($data)) {
            return JsonRenderer::render($rs, 401, ['message' => 'Token not found']);
        }

        $parties = $this->servicePartie->getUserParties($data['data']->id);
        $data['data']->parties = $parties;
        return JSONRenderer::render($rs, 200, $data['data']);
    }
}