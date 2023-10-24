<?php

namespace BotMan\Menu\Messages\Incoming;

use BotMan\BotMan\Messages\Incoming\Answer;

/**
 * Ответ на сообщение, содержащее меню
 */
class MenuAnswer extends Answer
{
    /**
     * ID сообщения, в котором было отражено меню
     * @var int|null
     */
    protected ?int $menuId = null;

    static function null(): static
    {
        return new MenuAnswer('');
    }

    /**
     * @return int|null
     */
    public function getMenuId(): ?int
    {
        return $this->menuId;
    }

    /**
     * @param int|null $menuId
     * @return MenuAnswer
     */
    public function setMenuId(?int $menuId): static
    {
        $this->menuId = $menuId;

        return $this;
    }
}