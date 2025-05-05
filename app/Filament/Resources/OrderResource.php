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
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

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
                    ->badge(fn (Order $order) => $order->status)
            ])
            ->filters([
                // Client filter (search by user name)
                Filter::make('client')
                    ->form([
                        Forms\Components\TextInput::make('client_name')
                            ->label('Client Name')
                            ->placeholder('Search client...')
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['client_name'],
                            fn (Builder $query, $name) => $query->whereHas('user', function($q) use ($name) {
                                $q->where('name', 'like', "%{$name}%");
                            })
                        );
                    }),

                // Order number filter
                Filter::make('order_number')
                    ->form([
                        Forms\Components\TextInput::make('order_number')
                            ->label('Order Number')
                            ->numeric()
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['order_number'],
                            fn (Builder $query, $number) => $query->where('order_number', $number)
                        );
                    }),

                // Total amount range filter
                Filter::make('total')
                    ->form([
                        Forms\Components\TextInput::make('min_total')
                            ->label('Min Total (RON)')
                            ->numeric(),
                        Forms\Components\TextInput::make('max_total')
                            ->label('Max Total (RON)')
                            ->numeric(),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['min_total'],
                                fn (Builder $query, $min) => $query->where('total', '>=', $min)
                            )
                            ->when(
                                $data['max_total'],
                                fn (Builder $query, $max) => $query->where('total', '<=', $max)
                            );
                    }),

                // Shipping address filter
                Filter::make('shipping_address')
                    ->form([
                        Forms\Components\TextInput::make('address')
                            ->label('Shipping Address Contains')
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['address'],
                            fn (Builder $query, $address) => $query->where('shipping_address', 'like', "%{$address}%")
                        );
                    }),

                // Status filter
                SelectFilter::make('status')
                    ->label('Order Status')
                    ->options([
                        'pending' => 'Pending',
                        'processing' => 'Processing',
                        'shipped' => 'Shipped',
                        'completed' => 'Completed',
                    ])
                    ->indicator('Status'),

                // Date range filter
                Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('from')
                            ->label('From Date'),
                        Forms\Components\DatePicker::make('until')
                            ->label('To Date'),
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
                    ->indicator('Date Range'),
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
