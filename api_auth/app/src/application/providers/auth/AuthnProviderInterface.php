<?php
namespace api_auth\application\providers\auth;

use api_auth\core\dto\AuthDTO;
use api_auth\core\dto\CredentialsDTO;

interface AuthnProviderInterface{
	public function register(CredentialsDTO $credentials):void;
	public function signin(CredentialsDTO $credentials):AuthDTO;
	public function refresh(AuthDTO $credentials):AuthDTO;
	public function getSignedInUser(string  $atoken):AuthDTO;
    public function validateToken(string $atoken):bool;
}
