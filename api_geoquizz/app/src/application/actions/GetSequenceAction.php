<?php

namespace api_geoquizz\application\actions;

use api_geoquizz\application\renderer\JsonRenderer;
use api_geoquizz\core\services\sequence\ServiceSequenceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetSequenceAction
{
    private ServiceSequenceInterface $serviceSequence;

    public function __construct(ServiceSequenceInterface $serviceSequence)
    {
        $this->serviceSequence = $serviceSequence;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $id = $args['id'];
        $sequence = $this->serviceSequence->getSequence($id);
        $data = [
            'type' => 'ressource',
            'sequence' => $sequence,
        ];

        return JSONRenderer::render($rs, 200, $data);
    }
}