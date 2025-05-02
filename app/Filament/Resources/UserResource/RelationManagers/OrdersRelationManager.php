<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Models\Order;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'orders';

    public function form(Form $form): Form
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

    public function table(Table $table): Table
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
                    ->badge(fn (Order $order) => $order->status, fn (Order $order) => $this->getStatusColor($order->status)), // Adding badge with color
                TextColumn::make('created_at')->label('Created At'),
            ])
            ->filters([
                // Add any necessary filters here
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
