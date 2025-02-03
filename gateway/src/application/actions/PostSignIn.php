<?php

namespace gateway\application\actions;

use DI\Container;
use gateway\application\renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


class PostSignIn extends AbstractAction{

    private $guzzle;

    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->guzzle = $container->get('guzzle.client.auth');
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $response = $this->guzzle->post("/signin", [
            'json' => $rq->getParsedBody()
        ]);
        return $response;
    }
}
