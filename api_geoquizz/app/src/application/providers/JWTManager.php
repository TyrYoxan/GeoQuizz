<?php
namespace api_geoquizz\application\providers;

use api_auth\application\providers\auth\AuthInvalidException;
use DI\Container;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use Monolog\Logger;

class JWTManager{

	protected int $tempsValidite;
	protected string $emmeteur, $audience;
	protected string $key, $algo;
	//protected Logger $loger;
	

	public function __construct(Container $co)
	{
		$this->tempsValidite = $co->get('token.temps.validite');
		$this->emmeteur = $co->get('token.emmeteur');
		$this->audience = $co->get('token.audience');
		// $this->key = parse_ini_file($co->get('token.key.path'))['JWT_SECRET_KEY'];
		$this->key = 'secret';//getenv('JWT_SECRET_KEY');
		$this->algo = $co->get('token.jwt.algo');

	}

	public function createAcessToken(String $id): string{
		$payload = [
			'iss'=> $this->emmeteur,
			'aud'=>$this->audience,
			'iat'=>time(),
			'exp'=>time()+$this->tempsValidite,
			'data' => [
                'user' =>$id
            ]
		];

		return JWT::encode($payload, $this->key, $this->algo);


	}
	public function createRefresh(array $paylod): string{
        $payload = [
            'iss'=> $this->emmeteur,
            'aud'=>$this->audience,
            'iat'=>time(),
            'exp'=>time()+$this->tempsValidite,
            'data' => [
                'user' => $paylod['data']['user']
            ]
        ];
        return JWT::encode($payload, $this->key, $this->algo);
	}

	public function decodeToken(string $token): array{
        try {
            return (array) JWT::decode($token, new Key($this->key, $this->algo));
        } catch (ExpiredException $e) {
            throw new \Exception($e->getMessage());
        } catch (SignatureInvalidException $e) {
            throw new \Exception($e->getMessage());
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
	}
}
