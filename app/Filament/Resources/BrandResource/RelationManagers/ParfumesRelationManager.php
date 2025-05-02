<?php

namespace App\Filament\Resources\BrandResource\RelationManagers;

use App\Models\Brand;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ParfumesRelationManager extends RelationManager
{
    protected static string $relationship = 'parfums';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\Select::make('brand_id')
                    ->label('Brand')
                    ->options(function () {
                        return Brand::where('active', true)
                            ->pluck('name', 'id')
                            ->toArray();
                    })
                    ->required(),
                Forms\Components\TextInput::make('price')->numeric()->required(),
                Forms\Components\TextInput::make('stock')->numeric()->required(),
                Forms\Components\Textarea::make('description')->label('Description')->required()
                    ->columnSpan(2),
                Forms\Components\Select::make('active')
                    ->options(['1' => 'Active', '0' => 'Inactive'])
                    ->default('1')
                    ->required()
                    ->columnSpan(2),

                Forms\Components\SpatieMediaLibraryFileUpload::make('images')
                    ->label('Parfum Images')
                    ->multiple()
                    ->maxFiles(5)
                    ->collection('images')
                    ->columnSpan(2),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('name')->label('Name'),
                TextColumn::make('brand.name')->label('Brand'),
                TextColumn::make('description')->label('Description'),
                TextColumn::make('price')
                    ->label('Price')
                    ->formatStateUsing(fn($state) => $state . ' RON'),
                TextColumn::make('stock')->label('Stock'),
                BooleanColumn::make('active')->label('Active'),
                Tables\Columns\ImageColumn::make('media.first.url')
                    ->label('Preview')
                    ->getStateUsing(function ($record) {
                        return $record->getFirstMediaUrl('images');
                    }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
