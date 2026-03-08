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
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Group;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make("Post Details")
                    ->description("Fill in the details of the post")
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        Group::make([
                            // 1. Title: Minimal 5 karakter & Custom Message
                            TextInput::make("title")
                                ->required()
                                ->rules(["required", "min:5"]) 
                                ->validationMessages([
                                    "min" => "Judul terlalu pendek, minimal 5 karakter", 
                                ]),

                            // 2. Slug: Unik & Minimal 3 karakter
                            TextInput::make("slug")
                                ->required()
                                ->rules(["required", "min:3"])
                                ->unique(ignoreRecord: true)
                                ->validationMessages([
                                    "unique" => "Slug must be unique",
                                    "min" => "Slug minimal 3 karakter ya!",
                                ]),

                            // 3. Category: Wajib dipilih
                            Select::make("category_id")
                                ->relationship("category", "name")
                                ->required() 
                                ->preload()
                                ->searchable(),

                            ColorPicker::make("color"),
                        ])->columns(2), 

                        MarkdownEditor::make("content"), 
                    ])
                    ->columnSpan(2),

                Group::make([
                    Section::make("Image Upload")
                        ->schema([
                            // 4. Image: Wajib diupload
                            FileUpload::make("image")
                                ->disk("public")
                                ->directory("posts")
                                ->required(), 
                        ]),

                    Section::make("Meta Information")
                        ->schema([
                            TagsInput::make("tags"),
                            Checkbox::make("published"),
                            DateTimePicker::make("published_at"),
                        ]),
                ])
                ->columnSpan(1),
            ])
            ->columns(3); 
    }
}