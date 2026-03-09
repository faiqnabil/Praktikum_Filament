<?php

namespace App\Filament\Resources\Posts\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn; // Import untuk tugas ikon
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                ->sortable(),

                TextColumn::make('slug')
                ->sortable(),
                
                TextColumn::make('category.name')
                ->sortable(),

                ColorColumn::make('color')
                ->sortable(),

                ImageColumn::make('image')
                ->disk('public'),

                TextColumn::make('created_at')
                ->Label('Created At')
                ->dateTime()
                ->sortable(),

            ])->defaultSort('created_at', 'desc')
            ->Filters([

            ])
                
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}