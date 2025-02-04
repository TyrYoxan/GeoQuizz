<?php

namespace api_geoquizz\application\actions;

use api_geoquizz\application\providers\JWTManager;
use api_geoquizz\application\renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetProfilAction extends AbstractAction
{
    private JWTManager $jwtManager;
    public function __construct(JWTManager $jwtManager)
    {
            $this->jwtManager = $jwtManager;
    }
    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $token = $rq->getHeader('Authorization')[0];
        $token = str_replace('Bearer ', '', $token);
        $data = $this->jwtManager->decodeToken($token);
        return JSONRenderer::render($rs, 200, $data['data']);
    }
}