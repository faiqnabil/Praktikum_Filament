<?php

namespace App\Filament\Resources\Categories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn; // Diimpor pada baris 9

class CategoriesTable
{
    /**
     * Mengonfigurasi tampilan tabel untuk resource Category.
     */
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // Menampilkan kolom nama kategori
                TextColumn::make('name'),

                // Menampilkan kolom slug kategori
                TextColumn::make('slug'),
            ])
            ->filters([
                //
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