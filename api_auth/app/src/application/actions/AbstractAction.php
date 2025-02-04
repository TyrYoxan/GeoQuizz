<?php

namespace api_auth\application\actions;


use DI\Container;
use Monolog\Logger;
use api_auth\application\providers\auth\AuthnProviderInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractAction
{
    protected AuthnProviderInterface $authProvider;
    protected string $formatDate;
    protected Container $cont;
    protected Logger $loger;

    public function __construct(Container $cont)
    {
        $this->authProvider = $cont->get(AuthnProviderInterface::class);
        $this->formatDate = $cont->get('date.format');
        $this->loger = $cont->get(Logger::class)->withName(get_class($this));
    }

    abstract public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface ;
    

}
