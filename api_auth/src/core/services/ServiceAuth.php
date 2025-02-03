<?php
namespace auth\core\services;

use DI\Container;
use auth\core\domain\entities\User;
use auth\core\dto\AuthDTO;
use auth\core\dto\CredentialsDTO;
use auth\core\repositoryInterfaces\AuthRepositoryInterface;
use auth\core\repositoryInterfaces\RepositoryEntityNotFoundException;
use Ramsey\Uuid\Uuid;

class ServiceAuth implements ServiceAuthInterface{
	protected AuthRepositoryInterface $repositoryAuth;

	public function __construct(Container $co)
	{
		$this->repositoryAuth= $co->get(AuthRepositoryInterface::class);
	}

	public function createUser(CredentialsDTO $credentials, int $role): string
	{
    	try {
        // Vérification que l'email n'existe pas déjà
        try {
            $this->repositoryAuth->getUserByMail($credentials->email);
            throw new \Exception("L'utilisateur avec l'email {$credentials->email} existe déjà.");
        } catch (RepositoryEntityNotFoundException $e) {
            // Si l'utilisateur n'est pas trouvé, on continue
        }

		$uuid = Uuid::uuid4()->toString();
        // Hachage du mot de passe
        $hashedPassword = password_hash($credentials->password, PASSWORD_BCRYPT);

        // Création d'une entité utilisateur
        $user = new User($uuid, $credentials->email, $hashedPassword, $role);

        // Appel au dépôt pour créer l'utilisateur
        $createdUser = $this->repositoryAuth->createUser($user);

        return $createdUser->id;
   	 } catch (\Exception $e) {
   	     throw new \Exception("Erreur lors de la création de l'utilisateur : " . $e->getMessage());
    	}
	}


	/*
	* Verifie les credentials avec ceux de la base de donnée
	*/
	public function byCredentials(CredentialsDTO $credentials): AuthDTO
	{

        $password = 'user1';
        $newHash = password_hash($password, PASSWORD_BCRYPT);
        echo $newHash;

		try{
			$user = $this->repositoryAuth->getUserByMail($credentials->email);
			if(!password_verify($credentials->password,$user->password)){

				throw new ServiceAuthBadPasswordException("Mauvais mot de passe");
			}
			return new AuthDTO($user->id, $user->role);
		}catch(RepositoryEntityNotFoundException $e){

			throw new ServiceAuthUserNotFoundException("Utilisateur $credentials->id non trouvé");
		}
	}

}
