<?php

namespace BotMan\Menu\Types;

use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\Menu\Messages\Outgoing\Actions\ButtonGroup;

class MenuGroup extends Menu
{
    /**
     * @param string $name
     * @param array<\BotMan\Menu\Types\Menu> $menu
     * @param \BotMan\Menu\Types\Menu|null $parent
     */
    public function __construct(string $name, array $menu, Menu $parent = null)
    {
        parent::__construct($name, '', $parent);

        foreach($menu as $item) {
            $this->addMenu($item);
        }
    }

    public static function create(string $name, array $menu = []): static
    {
        return new MenuGroup($name, $menu);
    }

    /**
     * @return ButtonGroup
     */
    public function toButtonGroup(): ButtonGroup
    {
        $data = [];
        foreach($this->actions as $menu) {
            $data[] = Button::create($menu->getTitle())->value($menu->getName());
        }

        return new ButtonGroup($data);
    }
}