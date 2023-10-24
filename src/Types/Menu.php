<?php

namespace BotMan\Menu\Types;

class Menu
{
    protected string $name;

    protected string $title;

    protected ?Menu $parent = null;

    protected array $actions = [];

    /**
     * @param string $name
     * @param string $title
     * @param Menu|null $parent
     */
    public function __construct(string $name, string $title, Menu $parent = null)
    {
        $this->name = $name;
        $this->title = $title;
        $this->parent = $parent;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return array
     */
    public function getActions(): array
    {
        return $this->actions;
    }

    /**
     * @return Menu|null
     */
    public function getParent(): ?Menu
    {
        return $this->parent;
    }

    /**
     * @param Menu|null $parent
     * @return Menu
     */
    public function setParent(?Menu $parent): Menu
    {
        $this->parent = $parent;
        return $this;
    }

    public function addMenu(Menu $menu): static
    {
        $menu->setParent($this);

        $this->actions[] = $menu;
        return $this;
    }

    public function addItems(array $items): static
    {
        foreach($items as $item) {
            $this->addMenu($item);
        }

        return $this;
    }

    public function resolveMenu(string $name = null): Menu
    {
        if ($name === null || $name === $this->getName())
            return $this;

        return self::searchMenu($this, $name);
    }

    /**
     * Функция ищет элемент меню по всему дереву через рекурсию до первого удачного совпадения
     *
     * @param Menu $parent
     * @param string $name
     * @return Menu|null
     */
    public static function searchMenu(Menu $parent, string $name): ?Menu
    {
        if ($parent->getName() === $name)
            return $parent;

        $result = null;

        collect($parent->actions)->each(function(Menu $subMenu) use (&$result, $name) {
            $result = self::searchMenu($subMenu, $name);
            return !$result;
        });

        return $result;
    }
}