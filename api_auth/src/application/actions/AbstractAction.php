<?php

namespace auth\application\actions;


use DI\Container;
use Monolog\Logger;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use auth\core\services\ServiceAuthInterface;
use auth\providers\auth\AuthnProviderInterface;

abstract class AbstractAction
{
    protected ServiceRDVInterface $serviceRdv;
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
