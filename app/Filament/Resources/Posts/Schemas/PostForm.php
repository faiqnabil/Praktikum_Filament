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
// PENTING: Import Group untuk menumpuk section secara vertikal di kanan
use Filament\Schemas\Components\Group; 

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // AREA KIRI: Post Details (Mengambil lebar 2 bagian)
                Section::make("Post Details")
                    ->description("Fill in the details of the post")
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        TextInput::make("title")
                            ->minLength(5)
                            ->required(),

                        TextInput::make("slug")
                            ->unique(ignoreRecord: true)
                            ->required(),

                        Select::make("category_id")
                            ->relationship("category", "name")
                            ->preload()
                            ->searchable()
                            ->required(),

                        ColorPicker::make("color"),

                        // Gunakan nama kolom 'body' agar sinkron dengan database
                        MarkdownEditor::make("body"), 
                    ])
                    ->columnSpan(2), // Mengatur lebar ke 2 bagian grid

                // AREA KANAN: Sidebar (Mengambil lebar 1 bagian)
                Group::make()
                    ->schema([
                        // Section Upload Gambar
                        Section::make("Image Upload")
                            ->schema([
                                FileUpload::make("image")
                                    ->disk("public")
                                    ->directory("posts"),
                            ]),

                        // Section Meta Data
                        Section::make("Meta Information")
                            ->schema([
                                TagsInput::make("tags"),
                                Checkbox::make("published"),
                                DateTimePicker::make("published_at"),
                            ]),
                    ])
                    ->columnSpan(1), // Menempati sisa 1 bagian grid di kanan
            ])
            // Mengaktifkan sistem grid 3 kolom pada skema utama
            ->columns(3); 
    }
}