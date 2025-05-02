<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Filament\Resources\OrderResource\Widgets\OrdersChart;
use App\Filament\Resources\OrderResource\Widgets\OrdersCreated;
use App\Models\Order;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'System Management';

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->label('User')
                    ->options(function () {
                        return User::pluck('name', 'id')->toArray();
                    })
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('order_number')->required(),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'processing' => 'Processing',
                        'shipped' => 'Shipped',
                        'completed' => 'Completed',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('total')->numeric()->required(),
                Forms\Components\TextInput::make('shipping_address')->required()->columnSpan(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Client')
                    ->formatStateUsing(fn($state) => $state),
                TextColumn::make('order_number')
                    ->label('Order Number')
                    ->formatStateUsing(fn($state) => '#' . $state),
                TextColumn::make('total')
                    ->label('Total')
                    ->formatStateUsing(fn($state) => $state . ' RON'),
                TextColumn::make('shipping_address')->label('Shipping Address'),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge(fn (Order $order) => $order->status, fn (Order $order) => $this->getStatusColor($order->status)),
                TextColumn::make('created_at')->label('Created At'),
            ])
            ->filters([
                // Add any necessary filters here
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
            RelationManagers\OrderItemsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
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
        return 'The number of orders';
    }

    /**
     * Get color based on order status.
     *
     * @param string $status
     * @return string
     */
    protected function getStatusColor(string $status): string
    {
        switch ($status) {
            case 'pending':
                return 'warning'; // Yellow
            case 'processing':
                return 'primary'; // Blue
            case 'shipped':
                return 'success'; // Green
            case 'completed':
                return 'success'; // Green
            default:
                return 'secondary'; // Default color
        }
    }
}
