<?php

namespace App\Filament\Resources\TicketResource\RelationManagers;

use App\Filament\Resources\TicketResource;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Livewire\Component as Livewire;

class CommentsRelationManager extends RelationManager
{
    protected static string $relationship = 'comments';

    protected static ?string $recordTitleAttribute = 'comment';

    protected function isTablePaginationEnabled(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Forms\Components\RichEditor::make('comment')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\FileUpload::make('attachments')
                        ->directory('comment-attachments/' . date('m-y'))
                        ->maxSize(2000)
                        ->enableDownload(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Stack::make([
                    Split::make([
                        TextColumn::make('user.name')
                            ->translateLabel()
                            ->weight('bold')
                            ->grow(false),
                        TextColumn::make('created_at')
                            ->translateLabel()
                            ->dateTime()
                            ->color('secondary'),
                    ]),
                    TextColumn::make('comment')
                        ->wrap()
                        ->html(),
                ]),
            ])
            ->filters([])
            ->headerActions([
                Tables\Actions\CreateAction::make()->mutateFormDataUsing(function (array $data): array {
                    $data['user_id'] = auth()->id();

                    return $data;
                })
                    ->label('Tambah Komentar')
                    ->after(function (Livewire $livewire) {
                        $ticket = $livewire->ownerRecord;

                        if (auth()->user()->hasAnyRole(['Admin Unit', 'Staf Unit'])) {
                            $receiver = $ticket->owner;
                        } else {
                            $receiver = User::whereHas(
                                'roles',
                                function ($q) {
                                    $q->where('name', 'Admin Unit')
                                        ->orWhere('name', 'Staf Unit');
                                },
                            )->get();
                        }

                        Notification::make()
                            ->title('Terdapat komentar baru pada tiket Anda')
                            ->actions([
                                Action::make('Lihat')
                                    ->url(TicketResource::getUrl('view', ['record' => $ticket->id])),
                            ])
                            ->sendToDatabase($receiver);
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('attachment')->action(function ($record) {
                    return response()->download('storage/' . $record->attachments);
                })->hidden(fn ($record) => $record->attachments == ''),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }
}
