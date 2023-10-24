<?php

namespace BotMan\Menu\Messages\Outgoing\Actions;

use BotMan\BotMan\Interfaces\QuestionActionInterface;
use JsonSerializable;

class ButtonGroup implements JsonSerializable, QuestionActionInterface
{
    /**
     * @var array<\BotMan\BotMan\Messages\Outgoing\Actions\Button>
     */
    protected array $buttons;

    /**
     * @param \BotMan\BotMan\Messages\Outgoing\Actions\Button[] $buttons
     */
    public function __construct(array $buttons)
    {
        $this->buttons = $buttons;
    }

    public function toArray(): array
    {
        $data = [];

        foreach($this->buttons as $button)
            $data[] = $button->toArray();

        return $data;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}