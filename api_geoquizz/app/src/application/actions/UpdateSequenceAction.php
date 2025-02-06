<?php

namespace api_geoquizz\application\actions;

use api_geoquizz\application\renderer\JsonRenderer;
use api_geoquizz\core\services\sequence\ServiceSequence;
use api_geoquizz\infrastructure\repository\NotFoundSequenceException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UpdateSequenceAction extends AbstractAction
{
    private ServiceSequence $serviceSequence;

    public function __construct(ServiceSequence $serviceSequence)
    {
        $this->serviceSequence = $serviceSequence;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $id = $args['id'];
        try {
            $this->serviceSequence->updateSequence($id);
        } catch (NotFoundSequenceException $e) {
            throw new NotFoundSequenceException($e->getMessage());
        }

        return JSONRenderer::render($rs, 200, ['Update' => 'OK']);
    }
}