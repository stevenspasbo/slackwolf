<?php namespace Slackwolf\Game\Command;

use Exception;
use Slack\Channel;
use Slack\ChannelInterface;
use Slackwolf\Game\Formatter\GameStatusFormatter;
use Slackwolf\Game\Game;
use Slack\RealTimeClient;
use Slackwolf\Game\GameManager;
use Slackwolf\Message\Message;

/**
 * Defines the WeatherCommand class.
 */
class WeatherCommand extends Command
{

    /**
     * {@inheritdoc}
     *
     * Constructs a new Weather command.
     */
    public function __construct(RealTimeClient $client, GameManager $gameManager, Message $message, array $args = null)
    {
        parent::__construct($client, $gameManager, $message, $args);
    }

    /**
     * {@inheritdoc}
     */
    public function fire()
    {
        $client = $this->client;

        if ( ! $this->gameManager->hasGame($this->channel)) {
            $client->getChannelGroupOrDMByID($this->channel)
               ->then(function (ChannelInterface $channel) use ($client) {
                   $client->send(":warning: Run this command in the game channel.", $channel);
               });
            return;
        }

          $this->gameManager->sendMessageToChannel($this->game, ":rain_cloud: It is raining. It is a cold rain, and the freezing drops chill you to the bone." );

    }
}
