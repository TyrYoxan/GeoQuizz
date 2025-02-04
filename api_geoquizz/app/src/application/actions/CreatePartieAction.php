<?php

namespace api_geoquizz\application\actions;

use api_geoquizz\application\renderer\JsonRenderer;
use api_geoquizz\core\dto\InputPartieDTO;
use api_geoquizz\core\services\partie\ServicePartieInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Validator;
use Slim\Exception\HttpBadRequestException;

class CreatePartieAction extends AbstractAction
{
    private ServicePartieInterface $servicePartie;

    public function __construct(ServicePartieInterface $servicePartie)
    {
        $this->servicePartie = $servicePartie;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $body = $rq->getParsedBody();
        $token = $rq->getHeader('Authorization')[0];
        //$info = json_decode();
        $partieInputValidator = Validator::key('sequence_photo', Validator::stringType()->notEmpty())
        ->key('score', Validator::intVal()->notEmpty());
        try{
            $partieInputValidator->assert($body);
        }catch(\Respect\Validation\Exceptions\NestedValidationException $e){
            throw new HttpBadRequestException($rq, implode(", ", $e->getMessages()));
        }

        $data = [
           'sequence_photo' => $body['sequence_photo'],
           'score' => $body['score'],
        ];

        $partieInputDto = new InputPartieDTO($data);

        $this->servicePartie->createPartie($partieInputDto);

        return JSONRenderer::render($rs, 201);

    }
}