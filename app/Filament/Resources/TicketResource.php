<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Filament\Resources\TicketResource\RelationManagers\CommentsRelationManager;
use App\Models\Priority;
use App\Models\ProblemCategory;
use App\Models\Ticket;
use App\Models\TicketStatus;
use App\Models\Unit;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Card;
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

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
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

                    Forms\Components\TextInput::make('title')
                        ->label(__('Title'))
                        ->required()
                        ->maxLength(255)
                        ->columnSpan([
                            'sm' => 2,
                        ]),

                    Forms\Components\RichEditor::make('description')
                        ->label(__('Description'))
                        ->required()
                        ->maxLength(65535)
                        ->columnSpan([
                            'sm' => 2,
                        ]),

                    Forms\Components\Placeholder::make('approved_at')
                        ->translateLabel()
                        ->hiddenOn('create')
                        ->content(fn (
                            ?Ticket $record,
                        ): string => $record->approved_at ? $record->approved_at->diffForHumans() : '-'),

                    Forms\Components\Placeholder::make('solved_at')
                        ->translateLabel()
                        ->hiddenOn('create')
                        ->content(fn (
                            ?Ticket $record,
                        ): string => $record->solved_at ? $record->solved_at->diffForHumans() : '-'),
                ])->columns([
                    'sm' => 2,
                ])->columnSpan(2),

                Card::make()->schema([
                    Forms\Components\Select::make('priority_id')
                        ->label(__('Priority'))
                        ->options(Priority::all()
                            ->pluck('name', 'id'))
                        ->searchable()
                        ->required(),

                    Forms\Components\Select::make('ticket_statuses_id')
                        ->label(__('Status'))
                        ->options(TicketStatus::all()
                            ->pluck('name', 'id'))
                        ->searchable()
                        ->required()
                        ->hiddenOn('create')
                        ->hidden(
                            fn () => !auth()
                                ->user()
                                ->hasAnyRole(['Super Admin', 'Admin Unit', 'Staff Unit']),
                        ),

                    Forms\Components\Select::make('responsible_id')
                        ->label(__('Responsible'))
                        ->options(User::ByRole()
                            ->pluck('name', 'id'))
                        ->searchable()
                        ->required()
                        ->hiddenOn('create')
                        ->hidden(
                            fn () => !auth()
                                ->user()
                                ->hasAnyRole(['Super Admin', 'Admin Unit']),
                        ),

                    Forms\Components\Placeholder::make('created_at')
                        ->translateLabel()
                        ->content(fn (
                            ?Ticket $record,
                        ): string => $record ? $record->created_at->diffForHumans() : '-'),

                    Forms\Components\Placeholder::make('updated_at')
                        ->translateLabel()
                        ->content(fn (
                            ?Ticket $record,
                        ): string => $record ? $record->updated_at->diffForHumans() : '-'),
                ])->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->translateLabel()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->translateLabel()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('problemCategory.name')
                    ->searchable()
                    ->label(__('Problem Category'))
                    ->toggleable(),
                Tables\Columns\TextColumn::make('ticketStatus.name')
                    ->label(__('Status'))
                    ->sortable(),
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
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            CommentsRelationManager::class,
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

    /**
     * Display tickets based on each role.
     *
     * If it is a Super Admin, then display all tickets.
     * If it is a Admin Unit, then display tickets based on the tickets they have created and their unit id.
     * If it is a Staff Unit, then display tickets based on the tickets they have created and the tickets assigned to them.
     * If it is a Regular User, then display tickets based on the tickets they have created.
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where(function ($query) {
                // Display all tickets to Super Admin
                if (auth()->user()->hasRole('Super Admin')) {
                    return;
                }

                if (auth()->user()->hasRole('Admin Unit')) {
                    $query->where('tickets.unit_id', auth()->user()->unit_id)->orWhere('tickets.owner_id', auth()->id());
                } elseif (auth()->user()->hasRole('Staff Unit')) {
                    $query->where('tickets.responsible_id', auth()->id())->orWhere('tickets.owner_id', auth()->id());
                } else {
                    $query->where('tickets.owner_id', auth()->id());
                }
            })
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getPluralModelLabel(): string
    {
        return __('Tickets');
    }
}
