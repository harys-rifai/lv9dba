<?php

namespace App\Filament\Resources\ChatBotResource\Pages;

use App\Filament\Resources\ChatBotResource;
use Filament\Resources\Pages\Page;

class ChatBot extends Page
{
    protected static string $resource = ChatBotResource::class;

    protected static string $view = 'filament.resources.chat-bot-resource.pages.chat-bot';
}
