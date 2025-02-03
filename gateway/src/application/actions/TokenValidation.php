<?php

namespace gateway\application\actions;

use DI\Container;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TokenValidation extends AbstractAction
{
    private $guzzle;

    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->guzzle = $container->get('guzzle.client.auth');
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        //pass authorization token via headers to the api.auth/tokens/validate endpoint
//        $response = $this->guzzle->get("api.auth/tokens/validate");

        $response = $this->guzzle->get("/tokens/validate", [
            'headers' => [
                'Authorization' => $rq->getHeader('Authorization')
            ]
        ]);
        return $response;
    }
}