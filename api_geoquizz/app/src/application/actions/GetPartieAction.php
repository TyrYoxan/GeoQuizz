<?php
namespace api_geoquizz\application\actions;

use api_geoquizz\application\renderer\JsonRenderer;
use api_geoquizz\core\services\partie\ServicePartieInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetPartieAction extends AbstractAction
{

    private ServicePartieInterface $servicePartie;

    public function __construct(ServicePartieInterface $servicePartie)
    {
        $this->servicePartie = $servicePartie;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $id = $args['id'];
        $partie = $this->servicePartie->getPartie($id);
        $data = [
            'type' => 'ressource',
            'partie' => $partie,
        ];
        return JSONRenderer::render($rs, 200, $data);
    }
}
