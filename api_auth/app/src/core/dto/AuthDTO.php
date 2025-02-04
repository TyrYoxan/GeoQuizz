<?php

namespace api_auth\core\dto;

use api_auth\core\domain\entities\User;

class AuthDTO extends DTO{
    protected string $id;
    protected int $role;
    protected string $email;
    protected ?string $pseudo;
    protected string $atoken;
    protected string $refreshToken;

    public function __construct(string $id, int $role, string $email, string $pseudo = null){
        $this->id=$id;
        $this->role=$role;
        $this->email=$email;
        $this->pseudo=$pseudo;
    }

    public function setAtoken(string $tok):void {
        $this->atoken = $tok;
    }

    public function setId(string $id){
        $this->id = $id;
        }
    public function setRole(int $role){
        $this->role = $role;
    }

    public static function fromUser(User $user): AuthDTO {
        return new self(
            $user->id,
            $user->role,
            $user->email,
            $user->pseudo
        );
    }


}
