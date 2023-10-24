<?php

namespace Tests\BotMan\Menu\Fixtures;

use BotMan\Menu\MenuConversation;
use BotMan\Menu\Messages\Incoming\MenuAnswer;
use BotMan\Menu\Messages\Outgoing\MenuQuestion;
use BotMan\Menu\Types\MenuAction;
use BotMan\Menu\Types\MenuExit;
use BotMan\Menu\Types\MenuGroup;
use BotMan\Menu\Types\MenuSection;

class TestConversation extends MenuConversation
{
    /**
     * @uses onAbout
     * @return void
     */
    public function buildMenu(): void
    {
        $this->menu = MenuSection::create('root','Главное меню','Это пример многоуровневого меню')
            ->addItems([
                MenuGroup::create('group1', [
                    MenuSection::create('wallets', 'Кошельки', 'Выберите подходящий кошелек')
                        ->addItems([
                            MenuSection::create('usdt', 'USDT', 'Кошелек USDT')
                                ->addItems([
                                    MenuSection::create('usdt.deposit', 'Пополнение', 'чето-там'),
                                    MenuSection::create('usdt.withdrawal', 'Вывод', 'чето-там')
                                ]),
                            MenuSection::create('usdc', 'USDC', 'Кошелек USDC')
                                ->addItems([
                                    MenuSection::create('usdc.deposit', 'Пополнение', 'чето-там'),
                                    MenuSection::create('usdc.withdrawal', 'Вывод', 'чето-там')
                                ])
                        ]),
                    MenuAction::create('about', 'О Нас', 'onAbout'),
                ]),
                MenuExit::create('exit', 'Выход из меню', new AnotherConversation()),
            ]);
    }

    public function onAbout(MenuAnswer $answer): MenuQuestion
    {
        return MenuQuestion::create('Слаженная команда джунов с дизайнером без души под чутким руководством большего дилдака');
    }
}