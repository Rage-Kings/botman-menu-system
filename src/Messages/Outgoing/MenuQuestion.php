<?php

namespace BotMan\Menu\Messages\Outgoing;

use BotMan\BotMan\Interfaces\QuestionActionInterface;
use BotMan\BotMan\Messages\Outgoing\Question;

class MenuQuestion extends Question implements QuestionActionInterface
{
    protected int|null $message_id = null;

    static function null(): static
    {
        return new MenuQuestion('');
    }

    /**
     * @return int|null
     */
    public function getMessageId(): ?int
    {
        return $this->message_id;
    }

    /**
     * @param int|null $message_id
     * @return \BotMan\Menu\Messages\Outgoing\MenuQuestion
     */
    public function setMessageId(int $message_id = null): static
    {
        $this->message_id = $message_id;
        return $this;
    }
}