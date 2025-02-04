<?php

namespace gateway\application\actions;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpUnauthorizedException;

class GenericAuthAction extends AbstractAction
{
    private \GuzzleHttp\Client $auth_client;

    public function __construct(\GuzzleHttp\Client $auth_client)
    {
        $this->auth_client = $auth_client;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $method = $rq->getMethod();
        $path = $rq->getUri()->getPath();
        $options = ['query' => $rq->getQueryParams()];
        if ($method === 'POST' || $method === 'PUT' || $method === 'PATCH') {
            $options['json'] = $rq->getParsedBody();
        }

        $auth = $rq->getHeader('Authorization')[0] ?? null;
        if ($auth) {
            if (str_starts_with($auth, 'Bearer ')) {
                $token = substr($auth, 7);

                $options['headers']['Authorization'] = 'Bearer ' . $token;
            } else {
                throw new HttpUnauthorizedException($rq, 'Invalid token format.');
            }
        }
        try {
            return $this->auth_client->request($method, $path, $options);
        } catch (ConnectException | ServerException $e) {
            throw new HttpInternalServerErrorException($rq, $e->getMessage());
        } catch (ClientException $e ) {
            match($e->getCode()) {
                400 => throw new HttpInternalServerErrorException($rq, $e->getMessage()),
                401 => throw new HttpUnauthorizedException($rq, $e->getMessage()),
                403 => throw new HttpForbiddenException($rq, $e->getMessage()),
                404 => throw new HttpNotFoundException($rq, $e->getMessage()),
            };
        }catch (GuzzleException $e) {
            throw new HttpInternalServerErrorException($rq, $e->getMessage());
        }
    }
}