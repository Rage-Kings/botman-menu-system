<?php

namespace BotMan\Menu\Types;

use BotMan\BotMan\Messages\Conversations\Conversation;

/**
 * Переход из меню на другой Conversation
 */
class MenuExit extends Menu
{
    protected Conversation $conversation;

    /**
     * @param string $name
     * @param string $title
     * @param \BotMan\BotMan\Messages\Conversations\Conversation $conversation
     * @param \BotMan\Menu\Types\Menu|null $parent
     */
    public function __construct(string $name, string $title, Conversation $conversation, Menu $parent = null)
    {
        parent::__construct($name, $title, $parent);
        $this->conversation = $conversation;
    }

    /**
     * @param string $name
     * @param string $title
     * @param \BotMan\BotMan\Messages\Conversations\Conversation $conversation
     * @param \BotMan\Menu\Types\Menu|null $parent
     * @return static
     */
    public static function create(string $name, string $title, Conversation $conversation, Menu $parent = null): static
    {
        return new MenuExit($name, $title, $conversation, $parent);
    }

    /**
     * @return \BotMan\BotMan\Messages\Conversations\Conversation
     */
    public function getConversation(): Conversation
    {
        return $this->conversation;
    }
}