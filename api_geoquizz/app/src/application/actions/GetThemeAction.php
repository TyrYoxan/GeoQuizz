<?php

namespace api_geoquizz\application\actions;

use api_geoquizz\application\renderer\JsonRenderer;
use api_geoquizz\core\services\sequence\ServiceSequenceInterface;
use api_geoquizz\application\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetThemeAction extends AbstractAction
{
    private ServiceSequenceInterface $serviceSequence;

    public function __construct(ServiceSequenceInterface $serviceSequence)
    {
        $this->serviceSequence = $serviceSequence;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        return JsonRenderer::render($rs, 200, $this->serviceSequence->getThemes());
    }
}