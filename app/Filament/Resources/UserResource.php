<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'System Management';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('email')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Name'),
                TextColumn::make('email')->label('Email'),
                TextColumn::make('created_at')->label('Created at'),

            ])
            ->filters([
                // Name filter
                Filter::make('name')
                    ->form([
                        Forms\Components\TextInput::make('name')
                            ->label('Search by name')
                            ->placeholder('Enter name...')
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['name'],
                            fn (Builder $query, $name) => $query->where('name', 'like', "%{$name}%")
                        );
                    })
                    ->indicator('Name contains'),

                // Email filter
                Filter::make('email')
                    ->form([
                        Forms\Components\TextInput::make('email')
                            ->label('Search by email')
                            ->placeholder('Enter email...')
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['email'],
                            fn (Builder $query, $email) => $query->where('email', 'like', "%{$email}%")
                        );
                    })
                    ->indicator('Email contains'),

                // Date range filter
                Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('from')
                            ->label('From date'),
                        Forms\Components\DatePicker::make('until')
                            ->label('To date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn (Builder $query, $date) => $query->whereDate('created_at', '>=', $date)
                            )
                            ->when(
                                $data['until'],
                                fn (Builder $query, $date) => $query->whereDate('created_at', '<=', $date)
                            );
                    })
                    ->indicator('Date range'),

                // Verified email filter (if you have email_verified_at column)
                SelectFilter::make('verified')
                    ->label('Email Verified')
                    ->options([
                        'verified' => 'Verified',
                        'unverified' => 'Unverified',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['value'] === 'verified',
                            fn (Builder $query) => $query->whereNotNull('email_verified_at')
                        )->when(
                            $data['value'] === 'unverified',
                            fn (Builder $query) => $query->whereNull('email_verified_at')
                        );
                    })
                    ->indicator('Verification status'),

                // New users filter (last 7 days)
                Filter::make('new_users')
                    ->label('New Users (Last 7 days)')
                    ->query(fn (Builder $query): Builder => $query->where('created_at', '>=', now()->subDays(7)))
                    ->toggle()
                    ->indicator('New users'),
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
            RelationManagers\OrdersRelationManager::class,
            RelationManagers\UserAddressRelationManager::class,
            RelationManagers\UserCompanyAddressRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::all()->count();
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'The number of users registered';
    }
}
