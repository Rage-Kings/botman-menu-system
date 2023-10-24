<?php

namespace BotMan\Menu\Types;

class MenuSection extends Menu
{
    protected string $text;

    /**
     * @param string $name
     * @param string $title
     * @param string $text
     * @param \BotMan\Menu\Types\Menu|null $parent
     */
    public function __construct(string $name, string $title, string $text, Menu $parent = null)
    {
        parent::__construct($name, $title, $parent);
        $this->text = $text;
    }

    /**
     * @param string $name
     * @param string $title
     * @param string $text
     * @param \BotMan\Menu\Types\Menu|null $parent
     * @return static
     */
    public static function create(string $name, string $title, string $text, Menu $parent = null): static
    {
        return new MenuSection($name, $title, $text, $parent);
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }
}