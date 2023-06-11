<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Filament\Resources\TicketResource\RelationManagers;
use App\Models\ProblemCategory;
use App\Models\Ticket;
use App\Models\Priority;
use App\Models\TicketStatus;
use App\Models\Unit;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('priority_id')
                    ->label(__('Priority'))
                    ->options(Priority::all()
                        ->pluck('name', 'id'))
                    ->searchable()
                    ->required(),

                Forms\Components\Select::make('unit_id')
                    ->label(__('Work Unit'))
                    ->options(Unit::all()
                        ->pluck('name', 'id'))
                    ->searchable()
                    ->required()
                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                        $unit = Unit::find($state);
                        if ($unit) {
                            $problemCategoryId = (int) $get('problem_category_id');
                            if ($problemCategoryId && $problemCategory = ProblemCategory::find($problemCategoryId)) {
                                if ($problemCategory->unit_id !== $unit->id) {
                                    $set('problem_category_id', null);
                                }
                            }
                        }
                    })
                    ->reactive(),

                Forms\Components\Select::make('problem_category_id')
                    ->label(__('Problem Category'))
                    ->options(function (callable $get, callable $set) {
                        $unit = Unit::find($get('unit_id'));
                        if ($unit) {
                            return $unit->problemCategories->pluck('name', 'id');
                        }
                        return ProblemCategory::all()->pluck('name', 'id');
                    })
                    ->searchable()
                    ->required(),

                Forms\Components\Select::make('ticket_statuses_id')
                    ->label(__('Status'))
                    ->options(TicketStatus::all()
                        ->pluck('name', 'id'))
                    ->searchable()
                    ->required()
                    ->hiddenOn('create'),

                Forms\Components\Select::make('responsible_id')
                    ->label(__('Responsible'))
                    ->options(User::all()
                        ->pluck('name', 'id'))
                    ->searchable()
                    ->required()
                    ->hiddenOn('create'),

                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),

                Forms\Components\RichEditor::make('description')
                    ->required()
                    ->maxLength(65535),

                Forms\Components\DateTimePicker::make('approved_at')
                    ->hiddenOn('create'),

                Forms\Components\DateTimePicker::make('solved_at')
                    ->hiddenOn('create'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('problemCategory.name'),
                Tables\Columns\TextColumn::make('ticketStatus.name'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
            ])
            ->defaultSort('created_at', 'desc');;
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'view' => Pages\ViewTicket::route('/{record}'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ])
            ->where(function ($query) {

                if (auth()->user()->hasRole('Super Admin')) {
                    return true;
                }

                if (auth()->user()->hasRole('Admin Unit')) {
                    $query->where('tickets.unit_id',  auth()->user()->unit_id)->orWhere('tickets.owner_id',  auth()->id());
                } elseif (auth()->user()->hasRole('Staff Unit')) {
                    $query->where('tickets.responsible_id',  auth()->id())->orWhere('tickets.owner_id',  auth()->id());
                } else {
                    $query->where('tickets.owner_id',  auth()->id());
                }
            });
    }
}
