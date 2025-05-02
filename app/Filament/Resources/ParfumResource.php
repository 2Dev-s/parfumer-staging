<?php
namespace App\Filament\Resources;

use App\Filament\Resources\ParfumResource\Pages;
use App\Filament\Resources\ParfumResource\RelationManagers;
use App\Models\Brand;
use App\Models\Parfum;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ParfumResource extends Resource
{
    protected static ?string $model = Parfum::class;

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationGroup = 'System Management';

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    public static function form(Form $form): Form
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

    public static function table(Table $table): Table
    {
        return $table
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
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\BrandRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListParfums::route('/'),
            'create' => Pages\CreateParfum::route('/create'),
            'edit' => Pages\EditParfum::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('active', true)->count();
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'The number of parfumes active';
    }
}
