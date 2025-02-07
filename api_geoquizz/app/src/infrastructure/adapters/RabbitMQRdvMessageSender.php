<?php

namespace api_geoquizz\infrastructure\adapters;


use api_geoquizz\application\interfaces\messages\MessageSenderInterface;
use api_geoquizz\core\dto\DTOPartie;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;


class RabbitMQRdvMessageSender implements MessageSenderInterface
{

    private $connection;
    private $channel;
    private $exchange;

    public function __construct(AMQPStreamConnection $connection, $exchange)
    {
        $this->connection = $connection;
        $this->channel = $connection->channel();
        $this->exchange = $exchange;
    }

    public function sendMessage(DTOPartie $partie, string $event): void
    {
        $msg = new AMQPMessage(json_encode(['event' => $event, 'partie' => json_encode($partie)]));
        $this->channel->basic_publish($msg, $this->exchange);
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}