<?php namespace Slackwolf\Game\Command;

use Exception;
use Slack\Channel;
use Slack\ChannelInterface;
use Slackwolf\Game\Formatter\PlayerListFormatter;
use Slackwolf\Game\Game;
use Slack\RealTimeClient;
use Slackwolf\Game\GameManager;
use Slackwolf\Message\Message;

/**
 * Defines the DeadCommand class.
 */
class DeadCommand extends Command
{

//    /**
//     * {@inheritdoc}
//     *
//     * Constructs a new Dead command.
//     */
//    public function __construct(RealTimeClient $client, GameManager $gameManager, Message $message, array $args = null)
//    {
//        parent::__construct($client, $gameManager, $message, $args);
//    }

    /**
     * {@inheritdoc}
     */
    public function fire()
    {
        $client = $this->client;

        if ( ! $this->gameManager->hasGame($this->channel)) {
            $client->getChannelGroupOrDMByID($this->channel)
               ->then(function (ChannelInterface $channel) use ($client) {
                   $client->send(":warning: No game in progress.", $channel);
               });
            return;
        }

        // TODO Check game status first.

        // build list of players
        $playersList = PlayerListFormatter::format($this->game->getDeadPlayers());
        if (empty($playersList))
        {
            $this->gameManager->sendMessageToChannel($this->game, "No one has died yet.");
        }
        else
        {
            $this->gameManager->sendMessageToChannel($this->game, ":angel: Players who have died: ".$playersList);
        }
    }
}