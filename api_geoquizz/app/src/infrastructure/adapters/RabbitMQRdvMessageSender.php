<?php

namespace appi_geoquizz\infrastructure\adapters;


use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;


class RabbitMQRdvMessageSender implements RdvMessageSenderInterface
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

    public function sendMessage(RDVDTO $rdv, string $event): void
    {
        $msg = new AMQPMessage(json_encode(['event' => $event, 'rdv' => json_encode($rdv)]));
        $this->channel->basic_publish($msg, $this->exchange);
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}