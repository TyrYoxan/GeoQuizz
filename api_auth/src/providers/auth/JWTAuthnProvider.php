<?php
namespace auth\providers\auth;

use DI\Container;
use auth\core\dto\AuthDTO;
use auth\core\dto\CredentialsDTO;
use auth\core\services\ServiceAuthBadPasswordException;
use auth\core\services\ServiceAuthInterface;

class JWTAuthnProvider implements AuthnProviderInterface{
	protected ServiceAuthInterface $serviceAuth;
	protected JWTManager $jwtManager;
	public function __construct(Container $co)
	{
		$this->serviceAuth = $co->get(ServiceAuthInterface::class);
		$this->jwtManager = $co->get(JWTManager::class);
	}
	
	public function register(CredentialsDTO $credentials): void
	{
    	try {
        	$this->serviceAuth->createUser($credentials, 1);
    	} catch (\Exception $e) {
        	throw new \Exception("Erreur lors de l'inscription de l'utilisateur : " . $e->getMessage());
    	}
	}


	public function signin(CredentialsDTO $credentials): AuthDTO
	{
		$user = $this->serviceAuth->byCredentials($credentials);
		$token = $this->jwtManager->createAcessToken($user);
		$authdto = new AuthDTO($user->id,$user->role);
		$authdto->setAtoken($token);
		return $authdto;

	}

    public function validateToken(string $atoken): bool{
        try {
            $this->jwtManager->decodeToken($atoken);
            return true;
        } catch (\Exception $e) {
            throw new AuthInvalidException($e->getMessage(), 0, $e);
        }
    }

	public function refresh(AuthDTO $credentials): AuthDTO
	{
	}

	public function getSignedInUser(string $atoken): AuthDTO
	{
		try{
		$token = $this->jwtManager->decodeToken($atoken);
		$authDto = new AuthDTO($token['sub'], $token['role']);
		return $authDto;
		}
		catch(\Exception $e){
			throw new AuthInvalidException($e->getMessage());
		}

	}

}
