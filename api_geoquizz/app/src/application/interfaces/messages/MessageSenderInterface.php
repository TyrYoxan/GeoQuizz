<?php
namespace api_geoquizz\application\interfaces\messages;


use api_geoquizz\core\dto\DTOPartie;

interface MessageSenderInterface
{
    public function sendMessage(DTOPartie $partie, string $event): void;
}