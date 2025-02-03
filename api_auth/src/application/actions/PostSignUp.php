<?php

namespace auth\application\actions;

use DI\Container;
use Error;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpInternalServerErrorException;
use auth\application\renderer\JsonRenderer;
use auth\core\dto\CredentialsDTO;
use auth\providers\auth\AuthnProviderInterface;

class PostSignUp extends AbstractAction
{
    public function __construct(Container $co)
    {
        parent::__construct($co);
        $this->authProvider = $co->get(AuthnProviderInterface::class);
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $jsonSignUp = $rq->getParsedBody();

        $rdvInputValidator = Validator::key('email', Validator::email()->notEmpty())
            ->key('password', Validator::stringType()->notEmpty());

        try {
            $rdvInputValidator->assert($jsonSignUp);

            $credentials = new CredentialsDTO('', $jsonSignUp['password'], $jsonSignUp['email']);

            $this->authProvider->register($credentials);

            //$this->logger->info("Inscription réussie pour l'utilisateur " . $jsonSignUp['email']);

            return JsonRenderer::render($rs, 201, ["message" => "Inscription réussie"]);
        } catch (NestedValidationException $e) {
            throw new HttpBadRequestException($rq, $e->getMessage());
        } catch (\Exception $e) {
            throw new HttpInternalServerErrorException($rq, $e->getMessage());
        }
    }
}
