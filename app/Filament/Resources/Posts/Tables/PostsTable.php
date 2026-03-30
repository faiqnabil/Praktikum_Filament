<?php

namespace App\Filament\Resources\Posts\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                ->sortable()
                ->searchable(),

                TextColumn::make('slug')
                ->sortable()
                ->searchable(),

                TextColumn::make('category.name')
                ->sortable()
                ->searchable(),

                ColorColumn::make('color')
                ->sortable(),

                ImageColumn::make('image')
                ->disk('public'),

                IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->color(fn (bool $state): string => $state ? 'success' : 'danger')
                    ->sortable(),
                
                TextColumn::make('created_at')
                ->Label('Created At')
                ->dateTime()
                ->sortable(),

            ])->defaultSort('created_at', 'asc')
            ->Filters([
                Filter::make('created_at')
                    ->label('Creation Date')
                    ->schema([
                        DatePicker::make('created_at')
                            ->label('Select Date :'),
                    ])
                    ->query(function ( $query, $data){
                        return $query
                            ->when(
                                $data['created_at'],
                                fn ($query, $date) => $query->whereDate('created_at', $date),
                            );
                    }),
                SelectFilter::make('category_id')
                    ->relationship('category', 'name')
                    ->label('Category')
                    ->preload(),
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