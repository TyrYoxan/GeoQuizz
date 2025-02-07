<?php

namespace gateway\middlewares;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Exception\HttpUnauthorizedException;

class PartieMiddleware
{
    private Client $partie_client;

    public function __construct(Client $auth_client)
    {
        $this->partie_client = $auth_client;
    }
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $token_line = $request->getHeaderLine('Authorization');
        list($token) = sscanf($token_line, "Bearer %s");

        if (!$token) {
            throw new HttpUnauthorizedException($request, "Token not provided");
        }

        try {
            // Vérifiez que le token n'est pas vide ou mal formé
            if (empty($token) || !is_string($token)) {
                throw new HttpUnauthorizedException($request, "Invalid token format");
            }

            $this->partie_client->request('POST', '/tokens/validate', [
                'json' => ['token' => $token]
            ]);
        } catch (ConnectException | ServerException $e) {
            throw new HttpInternalServerErrorException($request, "Internal server error ({$e->getCode()}, {$e->getMessage()})");
        } catch (ClientException $e) {
            if ($e->getCode() === 401) {
                throw new HttpUnauthorizedException($request, "Unauthorized ({$e->getCode()}, {$e->getMessage()})");
            }
        } catch (GuzzleException $e) {
            throw new HttpInternalServerErrorException($request, "Internal server error ({$e->getCode()}, {$e->getMessage()})");
        }

        return $handler->handle($request);
    }
}