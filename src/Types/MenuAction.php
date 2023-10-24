<?php

namespace BotMan\Menu\Types;

class MenuAction extends Menu
{
    protected string $handler;

    /**
     * @param string $name
     * @param string $title
     * @param string $handler
     * @param \BotMan\Menu\Types\Menu|null $parent
     */
    public function __construct(string $name, string $title, string $handler, Menu $parent = null)
    {
        parent::__construct($name, $title,  $parent);
        $this->handler = $handler;
    }

    /**
     * @param string $name
     * @param string $title
     * @param string $handler
     * @param \BotMan\Menu\Types\Menu|null $parent
     * @return static
     */
    public static function create(string $name, string $title, string $handler, Menu $parent = null): static
    {
        return new MenuAction($name, $title, $handler, $parent);
    }

    public function getHandler(): string
    {
        return $this->handler;
    }
}