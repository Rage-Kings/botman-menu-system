<?php

namespace BotMan\Menu;

use BotMan\Menu\Messages\Incoming\MenuAnswer;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\Menu\Messages\Outgoing\MenuQuestion;
use BotMan\Menu\Types\Menu;
use BotMan\Menu\Types\MenuAction;
use BotMan\Menu\Types\MenuExit;
use BotMan\Menu\Types\MenuGroup;
use BotMan\Menu\Types\MenuSection;

abstract class MenuConversation extends Conversation
{
    protected MenuQuestion $currentQuestion;

    protected Menu $menu;

    public function __construct()
    {
        $this->currentQuestion = MenuQuestion::null();
    }

    public function askMenu(MenuQuestion $menu, $next, $additionalParameters = []): static
    {
        $this->bot->reply($menu, $additionalParameters);
        $this->bot->storeConversation($this, $next, $menu, $additionalParameters);

        return $this;
    }

    public function runMenu(Answer $answer): static
    {
        if (!$answer instanceof MenuAnswer)
            return $this;

        $this->resolveMenu($answer);

        $this->askMenu($this->currentQuestion, function(Answer $currentAnswer) {
            $this->runMenu($currentAnswer);
        });

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function run(): void
    {
        $this->buildMenu();
        $this->runMenu(MenuAnswer::null());
    }

    /**
     * Функция для поиска текущего элемента меню
     *
     * @param MenuAnswer $answer
     * @return \BotMan\Menu\Types\Menu
     */
    public function resolveMenu(MenuAnswer $answer): Menu
    {
        $resolvedMenu = $this->menu->resolveMenu($answer->getValue());

        if ($resolvedMenu instanceof MenuSection)
            $this->currentQuestion = MenuQuestion::create($resolvedMenu->getText());
        elseif ($resolvedMenu instanceof MenuAction) {
            $handler = $resolvedMenu->getHandler();
            $this->currentQuestion = $this->$handler($answer);
        } elseif ($resolvedMenu instanceof MenuExit) {
            $this->getBot()->startConversation($resolvedMenu->getConversation());
        }

        $this->currentQuestion->setMessageId($answer->getMenuId());

        collect($resolvedMenu->getActions())->map(function (Menu|MenuGroup $menu) {
            if ($menu instanceof MenuGroup) {
                $this->currentQuestion->addAction($menu->toButtonGroup());
            } else {
                $this->currentQuestion->addButton(
                    Button::create($menu->getTitle())
                        ->value($menu->getName())
                );
            }
        });

        if ($parent = $resolvedMenu->getParent()) {
            if ($parent instanceof MenuGroup)
                $parent = $parent->getParent();

            $this->currentQuestion->addButton(
                Button::create('Назад')
                    ->value($parent->getName())
            );
        }

        return $resolvedMenu;
    }

    /**
     * @return \BotMan\Menu\Messages\Outgoing\MenuQuestion
     */
    public function getCurrentQuestion(): MenuQuestion
    {
        return $this->currentQuestion;
    }
}