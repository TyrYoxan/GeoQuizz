<?php

namespace auth\infrastructure\repositories;

use DI\Container;
use Monolog\Logger;
use auth\core\domain\entities\User;
use auth\core\repositoryInterfaces\AuthRepositoryInterface;
use auth\core\repositoryInterfaces\RepositoryEntityNotFoundException;


class PgAuthRepository implements AuthRepositoryInterface{
    protected \PDO $pdo;
    protected Logger $loger;

    public function __construct(Container $co)
    {
        $this->pdo=$co->get('pdo.auth');
        $this->loger = $co->get(Logger::class)->withName("PgAuth");
        
    }
    public function getUser(string $id): User
    {
        try{
        $query='select * from users where users.id=:id;';
        $rq=$this->pdo->prepare($query);
        $rq->execute(['id'=>$id]);
        $user = $rq->fetch();
            return new User($user['id'],$user['email'], $user['password'], $user['role']);
        }catch(\PDOException $e){
            $this->loger->error("PgAuthRep ". $e->getMessage());
            throw new RepositoryEntityNotFoundException($e->getMessage());
        }
    }

    public function createUser(User $user): User
    {
        try {
            $query = 'INSERT INTO users (id, email, password, role) VALUES (:id, :email, :password, :role) RETURNING id;';
            $stmt = $this->pdo->prepare($query);

            $stmt->execute([
                'id' => $user->id,
                'email' => $user->email,
                'password' => $user->password,
                'role' => $user->role,
            ]);

            $userId = $stmt->fetchColumn();
            return new User($userId, $user->email, $user->password, $user->role);
        } catch (\PDOException $e) {
            throw new \Exception("Erreur lors de la création de l'utilisateur : " . $e->getMessage());
        }
    }


    public function deletUser(string $id): void
    {
    }

    public function getUserByMail(string $email): User
    {
    try {
        $query = 'SELECT * FROM users WHERE users.email = :email;';
        $rq = $this->pdo->prepare($query);
        $rq->execute(['email' => $email]);
        $user = $rq->fetch();

        if (!$user) {
            throw new RepositoryEntityNotFoundException("Utilisateur avec l'email $email non trouvé.");
        }

        return new User($user['id'], $user['email'], $user['password'], $user['role']);
    } catch (\PDOException $e) {
        $this->loger->error($e->getMessage());
        throw new RepositoryEntityNotFoundException($e->getMessage());
    }
    }


}
