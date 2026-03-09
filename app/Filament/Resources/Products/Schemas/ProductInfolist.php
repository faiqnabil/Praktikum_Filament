<?php

    namespace App\Filament\Resources\Products\Schemas;

    use Filament\Schemas\Schema;
    use Filament\Infolists\Components\TextEntry;
    use Filament\Infolists\Components\ImageEntry;
    use Filament\Infolists\Components\IconEntry;
    use Filament\Schemas\Components\Tabs; // Perbaikan namespace
    use Filament\Schemas\Components\Tabs\Tab; // Perbaikan namespace

    class ProductInfolist
    {
        /**
         * Mengembalikan skema komponen untuk Infolist.
         */
        public static function configure(Schema $schema): Schema
        {
            return $schema
                ->components([
                    // 3. Tampilan Vertical
                    Tabs::make('Product Tabs')
                        ->tabs([
                        
                        // 4. Icon berbeda pada tiap tab
                        Tab::make('Product Details')
                            ->icon('heroicon-m-information-circle')
                            ->schema([
                                TextEntry::make('name')
                                    ->label('Product Name')
                                    ->weight('bold')
                                    ->color('primary'),
                                TextEntry::make('id')
                                    ->label('Product ID'),
                                TextEntry::make('sku')
                                    ->label('Product SKU')
                                    ->badge()
                                    ->color('success'),
                                TextEntry::make('description')
                                    ->label('Product Description')
                                    ->html(),
                                TextEntry::make('created_at')
                                    ->label('Product Creation Date')
                                    ->date('d M Y')
                                    ->color('info'),
                            ]),

                        Tab::make('Product Price and Stock')
                            ->icon('heroicon-m-banknotes')
                            ->schema([
                                TextEntry::make('price')
                                    ->label('Product Price')
                                    ->weight('bold')
                                    ->color('primary')
                                    ->icon('heroicon-s-currency-dollar')
                                    ->formatStateUsing(fn (string $state): string => "Rp " . number_format((float)$state, 0, ',', '.')),
                                
                                // 1 & 2. Badge dinamis dan warna berbeda berdasarkan stok
                                TextEntry::make('stock')
                                    ->label('Product Stock')
                                    ->icon('heroicon-s-cube')
                                    ->badge()
                                    ->color(fn (mixed $state): string => match (true) {
                                        $state <= 5 => 'danger',
                                        $state <= 20 => 'warning',
                                        default => 'success',
                                    }),
                            ]),

                        Tab::make('Image and Status')
                            ->icon('heroicon-m-photo')
                            ->schema([
                                ImageEntry::make('image')
                                    ->label('Product Image')
                                    ->disk('public')
                                    ->circular(),
                                IconEntry::make('is_active')
                                    ->label('Is Active?')
                                    ->boolean(),
                                IconEntry::make('is_featured')
                                    ->label('Is Featured?')
                                    ->boolean(),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->vertical(),
                ]);
        }
    }