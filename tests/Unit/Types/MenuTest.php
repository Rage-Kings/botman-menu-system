<?php

namespace Tests\BotMan\Menu\Unit\Types;

use BotMan\Menu\MenuConversation;
use BotMan\Menu\Messages\Incoming\MenuAnswer;
use PHPUnit\Framework\TestCase;
use Tests\BotMan\Menu\Fixtures\TestConversation;

class MenuTest extends TestCase
{
    protected MenuConversation $conversation;

    protected function setUp(): void
    {
        parent::setUp();

        $this->conversation = new TestConversation();
        $this->conversation->buildMenu();
    }

    public function test_resolve_menu(): void
    {
        $answer = MenuAnswer::create('')
            ->setValue('wallets');

        $menu = $this->conversation->resolveMenu($answer);
        $this->assertEquals('wallets', $menu->getName());
    }
}