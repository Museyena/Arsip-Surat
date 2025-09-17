<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class About extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

        protected static ?string $title = 'Tentang Saya';
    protected static string $view = 'filament.pages.about';
}
