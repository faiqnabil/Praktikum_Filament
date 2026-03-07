<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make("title")
                    ->minLength(5) // Tugas 1: Min 5 karakter
                    ->required(),

                TextInput::make("slug")
                    ->unique(ignoreRecord: true) // Tugas 1: Slug unik
                    ->required(),

                Select::make("category_id")
                    ->relationship("category", "name")
                    ->preload()
                    ->searchable()
                    ->required(),
                    
                ColorPicker::make("color"),

                // PERBAIKAN: Menggunakan 'body' agar tidak error Unknown Column
                MarkdownEditor::make("body"), 

                FileUpload::make("image")
                    ->disk("public")
                    ->directory("posts"),

                TagsInput::make("tags"),

                Checkbox::make("published"),

                DateTimePicker::make("published_at"),
            ]);
    }
}