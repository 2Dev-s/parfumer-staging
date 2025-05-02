<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class UserAddressRelationManager extends RelationManager
{
    protected static string $relationship = 'addresses';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('address_line1')
                    ->label('Address Line 1')
                    ->required(),
                Forms\Components\TextInput::make('address_line2')
                    ->label('Address Line 2')
                    ->required(),
                Forms\Components\TextInput::make('city')
                    ->label('City')
                    ->required(),
                Forms\Components\TextInput::make('state')
                    ->label('State')
                    ->required(),
                Forms\Components\TextInput::make('postal_code')
                    ->label('Postal Code')
                    ->required(),
                Forms\Components\TextInput::make('country')
                    ->label('Country')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('address_line1')->label('Address Line 1'),
                Tables\Columns\TextColumn::make('address_line2')->label('Address Line 2'),
                Tables\Columns\TextColumn::make('city')->label('City'),
                Tables\Columns\TextColumn::make('state')->label('State'),
                Tables\Columns\TextColumn::make('postal_code')->label('Postal Code'),
                Tables\Columns\TextColumn::make('country')->label('Country'),
                Tables\Columns\TextColumn::make('created_at')->label('Created At'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
//                Tables\Actions\CreateAction::make(),
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
